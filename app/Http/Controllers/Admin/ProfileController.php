<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{UserDetail, Address, User};
use Illuminate\Support\Facades\{Hash, Storage, Validator};
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

/**
 * Class ProfileController
 *
 * This controller handles the management of user profiles.
 */
class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     */
    public function showProfile()
    {
        try {
            $user = Auth::user();
            return view('admin.profile.profile', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Profile Not found');
        }
    }

    /**
     * Update the user's profile information.
     *
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required',
            'country' => 'nullable|exists:countries,id',
            'state' => 'nullable|exists:states,id',
            'city' => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|min:2|max:50',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'back_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        try {
            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ];

            $user->update($userData);

            $profilePicPath = ($user->user_detail) ? $user->user_detail->profile_path : null;
            $backPicPath = ($user->user_detail) ? $user->user_detail->back_profile_path : null;

            if ($request->hasFile('profile_picture')) {
                if ($user->user_detail && $user->user_detail->profile_path) {
                    Storage::disk('public')->delete($user->user_detail->profile_path);
                }

                $profilePicPath = $request->file('profile_picture')->store('profile_pictures', 'public');
            }
            if ($request->hasFile('back_picture')) {
                if ($user->user_detail && $user->user_detail->back_profile_path) {
                    Storage::disk('public')->delete($user->user_detail->back_profile_path);
                }
                $backPicPath = $request->file('back_picture')->store('background_pictures', 'public');
            }

            $userDetailsData = [
                'address' => $request->address,
                'gender' => $request->gender,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'pincode' => $request->postal_code,
                'profile_path' => $profilePicPath ?? null,
                'back_profile_path' => $backPicPath ?? null,
            ];

            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                $userDetailsData
            );

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Profile update failed. Please try again.');
        }
    }

    /**
     * Show the change password form.
     *
     */
    public function showChangePasswordForm()
    {
        try {
            $user = auth()->user();
            return view('admin.profile.change_password', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Not found' . $e->getMessage());
        }
    }

    /**
     * Change password function.
     *
     */
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = Auth::user();

            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return redirect()->back()->with('error', 'The provided password does not match your current password.');
            }

            $user->update(['password' => Hash::make($validatedData['password'])]);
            Auth::logout();
            return redirect()->route('login');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Password update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Password update failed. Please try again.');
        }
    }
}
