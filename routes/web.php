<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function (){
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
});

Route::get('/request-form', [DashboardController::class, 'requestForm'])->name('request.form');
Route::post('/send-message', [DashboardController::class, 'sendMessage'])->name('send.message');

Route::get('/otp', [AuthenticatedSessionController::class, 'showOtpForm'])->name('otp.form');
Route::post('/verify/otp', [AuthenticatedSessionController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/otp/resend', [AuthenticatedSessionController::class, 'resendOtp'])->name('otp.resend');

Route::middleware('auth')->group(function () {
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile-pic-update', [ProfileController::class, 'updateProfilePic'])->name('update-profile-pic');
});

require __DIR__.'/auth.php';
