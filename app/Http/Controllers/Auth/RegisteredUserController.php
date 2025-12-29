<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\DynamicEmail;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $nameData = explode(' ', $request->name);
        $firstName = $nameData[0] ?? '';
        $lastName = $nameData[1] ?? '';
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'encrypt_password' => jsencode_userdata($request->password),
        ]);

        $user->assignRole('User');

        event(new Registered($user));

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
