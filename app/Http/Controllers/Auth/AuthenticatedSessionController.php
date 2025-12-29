<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            event(new Failed('web', $user, ['email' => $request->email]));
            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }
        // ✅ If 2FA is enabled and user is subadmin, start OTP flow
        if ($user->hasRole('Subadmin') && isSubadmin2FAEnabled()) {
            $otp = rand(100000, 999999);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            // Send OTP to admin
            $admin = User::where('id', 1)->first();
            if ($admin) {
                $admin->notify(new \App\Notifications\SendSubadminOtpNotification($otp, $user));
            } else {
                return back()->withErrors(['email' => 'No admin found to notify.']);
            }

            session(['pending_subadmin_id' => $user->id]);

            return redirect()->route('otp.form');
        }
        // ✅ Regular login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    function showOtpForm(): View
    {
        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::find(session('pending_subadmin_id'));

        if (
            !$user ||
            $user->otp_code !== $request->otp ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // ✅ OTP is valid – login the user
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('pending_subadmin_id');

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }


    function resendOtp(Request $request)
    {
        $user = User::find(session('pending_subadmin_id'));

        if (!$user) {
            return back()->withErrors(['otp' => 'Session expired. Please login again.']);
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // Send OTP to admin
        $admin = User::where('id', 1)->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\SendSubadminOtpNotification($otp, $user));
        } else {
            return back()->withErrors(['email' => 'No admin found to notify.']);
        }

        return back()->with('status', 'OTP resent successfully.');
    }
}
