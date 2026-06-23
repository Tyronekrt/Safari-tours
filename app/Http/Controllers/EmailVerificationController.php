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
     * Show the verification success page.
     */
    public function success()
    {
        return view('auth.verification-success');
    }

    /**
     * Verify the user's email.
     */
    public function verify(Request $request, $token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification link. Please request a new verification email.');
        }

        if ($user->isVerified()) {
            // If already verified, just log them in
            Auth::login($user);
            return redirect()->route('home')
                ->with('success', 'Your email is already verified. You have been logged in.');
        }

        // Verify the user
        $user->verifyEmail();

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
                'email' => 'required|email|exists:users,email'
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
            return redirect()->route('home')
                ->with('info', 'Your email is already verified.');
        }

        try {
            // Generate new verification token
            $verificationToken = $user->generateVerificationToken();
            $verificationUrl = route('verification.verify', ['token' => $verificationToken]);

            // Send verification email
            \Mail::to($user->email)->send(new \App\Mail\EmailVerification($user, $verificationUrl));

            $message = 'Verification email has been resent to ' . $user->email . '. Please check your inbox.';
            
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
            'email' => 'required|email|exists:users,email'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'No account found with this email address.');
        }

        if ($user->isVerified()) {
            return redirect()->route('login')
                ->with('info', 'This email is already verified. You can login now.')
                ->with('verified_email', $user->email);
        }

        try {
            // Generate new verification token
            $verificationToken = $user->generateVerificationToken();
            $verificationUrl = route('verification.verify', ['token' => $verificationToken]);

            // Send verification email
            \Mail::to($user->email)->send(new \App\Mail\EmailVerification($user, $verificationUrl));

            return redirect()->route('login')
                ->with('success', 'Verification email has been sent to ' . $user->email . '. Please check your inbox and click the verification link to complete your registration.')
                ->with('resent_email', $user->email);
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to send verification email: ' . $e->getMessage());
        }
    }
}
