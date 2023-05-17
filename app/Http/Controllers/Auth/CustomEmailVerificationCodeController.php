<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;

class CustomEmailVerificationCodeController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);
        //return response()->json(['message' => $request->all()], 400);

        $email = $request->input('email');
        $code = $request->input('code');

        // Check if the verification code exists and is valid
        $verificationCode = \DB::table('verification_codes')
            ->where('email', '=', $email)
            ->where('code', '=', $code)
            ->where('expiration', '>=', Carbon::now())
            ->first();

        if ($verificationCode) {
            // Verification code is valid
            // Update the user's email verification status
            User::where('email', $email)->update(['email_verified_at' => Carbon::now()]);

            // Delete the verification code from the database
            \DB::table('verification_codes')->where('email', $verificationCode->id)->delete();

            return response()->json(['message' => 'Email verified successfully'], 200);
        } else {
            // Verification code is invalid or expired
            return response()->json(['message' => 'Invalid verification code or expired'], 400);
        }
    }
}
