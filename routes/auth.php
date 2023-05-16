<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

//Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware('guest')
//                ->name('register');
//
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//                ->middleware('guest')
//                ->name('login');
//
//Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.email');
//
//Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware('guest')
//                ->name('password.store');
//
//Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//
//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->middleware('auth')
//                ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
