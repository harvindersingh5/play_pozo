<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $settings = PaymentSetting::where('user_id', auth()->id())->first();

        return view('admin.payment_settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.payment_settings.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Handle Stripe keys
        if (!is_null($request->secret_key) || !is_null($request->public_key)) {
            $checkApiKeys = $this->checkStripeDetails($request);
            $check = json_decode($checkApiKeys->getContent(), true);

            if ($check['status'] != 'success') {
                return redirect()->back()->with('error', 'Your Stripe keys are not working. Please check and try to submit again.');
            }

            $setting = PaymentSetting::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'secret_key' => $request->secret_key,
                    'public_key' => $request->public_key,
                    'transfer_to' => 'Stripe',
                ]
            );
        }

        // Handle PayPal keys
        if (!is_null($request->paypal_client_id) || !is_null($request->paypal_client_secret)) {
            $checkPaypalKeys = $this->checkPaypalDetails($request);
            $check = json_decode($checkPaypalKeys->getContent(), true);

            if ($check['status'] != 'success') {
                return redirect()->back()->with('error', 'Your PayPal keys are not working. Please check and try to submit again.');
            }

            $setting = PaymentSetting::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'paypal_client_id' => $request->paypal_client_id,
                    'paypal_client_secret' => $request->paypal_client_secret,
                    'paypal_mode' => $request->paypal_mode ?? 'sandbox',
                ]
            );
        }


        return redirect()->route('admin.payment-settings.index')->with('success', 'Your payment settings have been updated successfully.');
    }

    public function edit(PaymentSetting $setting, $type)
    {
        return view('admin.payment_settings.edit', compact('setting', 'type'));
    }

    public function update(Request $request, PaymentSetting $setting)
    {
        $user = auth()->user();
        // Handle Stripe keys
        if (!is_null($request->secret_key) || !is_null($request->public_key)) {
            $checkApiKeys = $this->checkStripeDetails($request);
            $check = json_decode($checkApiKeys->getContent(), true);

            if ($check['status'] != 'success') {
                return redirect()->back()->with('error', 'Your Stripe keys are not working. Please check and try to submit again.');
            }

            $setting->update([
                'secret_key' => $request->secret_key,
                'public_key' => $request->public_key,
                'transfer_to' => 'Stripe',
            ]);
        }

        // Handle PayPal keys
        if (!is_null($request->paypal_client_id) || !is_null($request->paypal_client_secret)) {
            $checkPaypalKeys = $this->checkPaypalDetails($request);
            $check = json_decode($checkPaypalKeys->getContent(), true);

            if ($check['status'] != 'success') {
                return redirect()->back()->with('error', 'Your PayPal keys are not working. Please check and try to submit again.');
            }

            $setting->update([
                'paypal_client_id' => $request->paypal_client_id,
                'paypal_client_secret' => $request->paypal_client_secret,
                'paypal_mode' => $request->paypal_mode ?? 'sandbox',
            ]);
        }

        return redirect()->route('admin.payment-settings.index')->with('success', 'Your keys has been updated');
    }


    public function checkStripeDetails(Request $request)
    {
        try {
            config(['cashier.key' => $request->public_key]);
            config(['cashier.secret' => $request->secret_key]);

            $checkApiKey = Cashier::stripe()->products->all(['limit' => 1]);
            return response()->json([
                'status' => 'success',
                'message' => 'Your Api Key is working',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in Keys Update: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function checkPaypalDetails(Request $request)
    {
        Log::info('Entering checkPaypalDetails method.');
        Log::info('Request data received:', $request->all());

        try {
            $mode = $request->paypal_mode ?? 'sandbox';
            $clientId = $request->paypal_client_id;
            $clientSecret = $request->paypal_client_secret;

            config([
                'paypal.mode'                         => $mode,
                'paypal.' . $mode . '.client_id'      => $clientId,
                'paypal.' . $mode . '.client_secret'  => $clientSecret,
            ]);

            $provider = new PayPalClient;

            $accessTokenResponse = $provider->getAccessToken();

            if (isset($accessTokenResponse['error'])) {
                $paypalErrorMessage = $accessTokenResponse['error']['error_description'] ?? 'Unknown PayPal API error.';
                Log::error('PayPal API Key Validation failed: ' . $paypalErrorMessage);
                return response()->json([
                    'status' => 'error',
                    'message' => 'PayPal API Error: ' . $paypalErrorMessage,
                ]);
            }

            // $accessToken = $accessTokenResponse['access_token'];

            // Log::info('PayPal access token successfully obtained.', ['token_start' => substr($accessToken, 0, 10) . '...']);

            return response()->json([
                'status' => 'success',
                'message' => 'Your PayPal API Key is working',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in PayPal Keys Validation: ' . $e->getMessage());
            Log::error('PayPal Validation Exception Trace:', ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'status' => 'error',
                'message' => 'PayPal API Error: ' . $e->getMessage(),
            ]);
        }
    }


    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'required|exists:payment_settings,id',
            'gateway' => 'required|in:stripe,paypal',
            'status' => 'required|in:true,false',
        ]);

        $paymentSettingId = $request->input('id');
        $gateway = $request->input('gateway');
        // $status = $request->input('status'); 
        $status = $request->boolean('status');

        try {
            DB::beginTransaction();

            $paymentSetting = PaymentSetting::find($paymentSettingId);

            if (!$paymentSetting) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Payment setting not found.'], 404);
            }

            if ($status === true) {
                $paymentSetting->is_stripe_active = false;
                $paymentSetting->is_paypal_active = false;

                if ($gateway === 'stripe') {
                    $paymentSetting->is_stripe_active = true;
                } elseif ($gateway === 'paypal') {
                    $paymentSetting->is_paypal_active = true;
                }
            } else {
                if ($gateway === 'stripe') {
                    $paymentSetting->is_stripe_active = false;
                } elseif ($gateway === 'paypal') {
                    $paymentSetting->is_paypal_active = false;
                }
            }

            // dd($request->all(), $paymentSetting->getAttributes());

            $paymentSetting->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Payment gateway status updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update payment gateway status.', 'error' => $e->getMessage()], 500);
        }
    }
}
