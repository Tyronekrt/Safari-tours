<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    /**
     * Show the verification notice page.
     */
    public function notice()
    {
        return view('auth.verification-notice');
    }

    /**
     * Show the verification code entry page.
     */
    public function showCodeForm()
    {
        return view('auth.verification-code');
    }

    /**
     * Show the verification success page.
     */
    public function success()
    {
        return view('auth.verification-success');
    }

    /**
     * Verify the user's email using code.
     */
    public function verifyWithCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,deleted_at,NULL',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email address.');
        }

        if ($user->isVerified()) {
            Auth::login($user);
            return redirect()->route('verification.success')
                ->with('success', 'Your email is already verified. You have been logged in.');
        }

        if (!$user->isVerificationCodeValid($request->code)) {
            return back()->with('error', 'Invalid or expired verification code. Please request a new code.');
        }

        // Verify the user
        $user->verifyEmailWithCode($request->code);

        // Log the user in
        Auth::login($user);

        return redirect()->route('verification.success')
            ->with('success', 'Your email has been successfully verified! Welcome to Safari Tours!');
    }

    /**
     * Verify the user's email (legacy method for backward compatibility).
     */
    public function verify(Request $request, $token)
    {
        // Log the verification attempt for debugging
        \Log::info('Email verification attempt', ['token' => $token]);

        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            \Log::warning('Invalid verification token', ['token' => $token]);
            return redirect()->route('login')
                ->with('error', 'Invalid verification link. The link may have expired or already been used. Please request a new verification email.');
        }

        if ($user->isVerified()) {
            \Log::info('User already verified', ['user_id' => $user->id, 'email' => $user->email]);
            // If already verified, just log them in
            Auth::login($user);
            return redirect()->route('verification.success')
                ->with('success', 'Your email is already verified. You have been logged in.');
        }

        // Verify the user
        $user->verifyEmail();

        \Log::info('User successfully verified', ['user_id' => $user->id, 'email' => $user->email]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('verification.success')
            ->with('success', 'Your email has been successfully verified! Welcome to Safari Tours!');
    }

    /**
     * Resend the verification email.
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user && $request->has('email')) {
            // Allow non-logged-in users to request resend by providing email
            $request->validate([
                'email' => 'required|email|exists:users,email,deleted_at,NULL'
            ]);

            $user = \App\Models\User::where('email', $request->email)->first();

            if (!$user) {
                return back()->with('error', 'No account found with this email address.');
            }

            if ($user->isVerified()) {
                return back()->with('info', 'This email is already verified. You can login.');
            }
        } elseif (!$user) {
            // If not logged in and no email provided, redirect to login
            return redirect()->route('login')
                ->with('error', 'Please login to resend verification email, or provide your email below.');
        }

        if ($user->isVerified()) {
            return redirect()->route('verification.success')
                ->with('success', 'Your email is already verified. You have been logged in.');
        }

        try {
            // Generate new verification code
            $verificationCode = $user->generateVerificationCode();

            // Send verification email
            \Mail::to($user->email)->send(new \App\Mail\EmailVerification($user, $verificationCode));

            $message = 'Verification code has been sent to ' . $user->email . '. Please check your inbox. The code will expire in 15 minutes.';

            if (Auth::check()) {
                return back()->with('success', $message);
            } else {
                return back()->with('success', $message)->with('resent_email', $user->email);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend verification email: ' . $e->getMessage());
        }
    }

    /**
     * Resend verification email from login page specifically.
     */
    public function resendFromLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,deleted_at,NULL'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'No account found with this email address.');
        }

        if ($user->isVerified()) {
            Auth::login($user);
            return redirect()->route('verification.success')
                ->with('success', 'Your email is already verified. You have been logged in.');
        }

        try {
            // Generate new verification code
            $verificationCode = $user->generateVerificationCode();

            // Send verification email
            \Mail::to($user->email)->send(new \App\Mail\EmailVerification($user, $verificationCode));

            return redirect()->route('login')
                ->with('success', 'Verification code has been sent to ' . $user->email . '. Please check your inbox and enter the code to complete your registration. The code will expire in 15 minutes.')
                ->with('resent_email', $user->email);
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to send verification email: ' . $e->getMessage());
        }
    }
}
