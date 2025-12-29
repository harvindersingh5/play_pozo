<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserDetail;
use App\Services\ThumbnailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    protected $thumbnailService;

    public function __construct(ThumbnailService $thumbnailService)
    {
        $this->thumbnailService = $thumbnailService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateProfilePic(Request $request)
    {
        try {
            $request->validate([
                'profile_pic' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user = auth()->user();
            $profilePicPath = null;
            if ($request->hasFile('profile_pic')) {
                $file = $request->profile_pic;
                if ($user->user_detail?->profile_path) {
                    delete_image($user->user_detail?->profile_path);
                }
                $profilePic = store_image($file, 'profile_pictures');
                $profilePicPath = $profilePic['url'] ?? null;
            }

            UserDetail::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'profile_path' => $profilePicPath,
                ]
            );

            if ($request->hasFile('profile_pic')) {
                if ($user->thumbnails) {
                    foreach ($user->thumbnails as $thumbnail) {
                        $thumbnail->delete();
                    }
                }

                $user->thumbnails->each(function ($thumbnail) {
                    delete_image($thumbnail?->url);
                    $thumbnail->delete();
                });

                $this->thumbnailService->generateThumbnails(
                    $request->file('profile_pic'),
                    $user,
                    [
                        'small' => [100, 100],
                        'medium' => [300, 200],
                        'large' => [800, 600],
                    ],
                    'profile_pic_thumbnails'
                );
            }

            $user->refresh();
            $thumbnails = $user->thumbnails;

            $updatedThumbnailsHtml =  view('partials.profile_thumbnails', ['thumbnails' => $thumbnails])->render();

            return response()->json([
                'status' => true,
                'message' => 'Profile pic updated successfully.',
                'thumbnails_html' => $updatedThumbnailsHtml,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error' . $e->getMessage(),
            ]);
        }
    }
}
