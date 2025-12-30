<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\DynamicEmail;
use App\Models\EmailTemplate;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegisterRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            
            $nameData = explode(' ', $data['full_name']);
            $firstName = $nameData[0] ?? '';
            $lastName = $nameData[1] ?? '';
            
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'encrypt_password' => jsencode_userdata($request['password']),
            ]);

            //phone number filled
            if($request->filled('phone_number')) {
                $user->user_detail()->create([
                    'phone_country_code' => $request['phone_country_code'],
                    'phone_number' => $request['phone_number'],
                ]);
            }
            
            //Assingn Manager role
            $user->assignRole(config('constant.role.manager.name'));
            
            event(new Registered($user));
            
            DB::commit();
            
            // try {
            //     $template = EmailTemplate::findByName('registration_confirmation');

            //     $dynamicData = [
            //         'user_name' => $user->full_name,
            //         'user_email' => $user->email,
            //         'app_name' => config('app.name'),
            //         'app_url' => config('app.url'),
            //         'verification_link' => url('/verify-email/' . $user->id . '/' . sha1($user->email)),
            //     ];
            //     Mail::to($user->email)->send(new DynamicEmail($template, $dynamicData));
            //     \Log::info('Email sent successfully to ' . $user->email);
            // } catch (\Exception $e) {
            //     \Log::error('Email sending failed: ' . $e->getMessage());
            // }


            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(false); // Email is already taken
        }

        return response()->json(true); // Email is unique
    }
}
