<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(
        //         config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
        //     );
        // }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }
       
        // return redirect()->intended(
        //     config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1'
        // );

        $userId = $request->route('id');
        $verificationToken = $request->route('hash');

        $user = User::find($userId);

        if ($user && hash_equals($verificationToken, $user->getEmailVerificationToken())) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return redirect()->intended(config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1');
        } else {
            // Verification failed
            return redirect()->intended(config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=0');
        }
    }
}
