<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset as PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Show the password reset request form.
     */
    public function showRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Handle the password reset request.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,NULL,id,deleted_at,NULL'
        ]);

        // Check for active user only
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email address.');
        }

        try {
            // Generate password reset token
            $resetToken = $user->generatePasswordResetToken();
            $resetUrl = route('password.reset', ['token' => $resetToken]);

            // Send password reset email
            Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl));

            return redirect()->route('login')
                ->with('success', 'Password reset link has been sent to your email. Please check your inbox.')
                ->with('reset_email', $user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send password reset email: ' . $e->getMessage());
        }
    }

    /**
     * Show the password reset form.
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Handle the password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:8|confirmed'
        ]);

        // Check for active user only
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email address.');
        }

        if (!$user->isPasswordResetTokenValid($request->token)) {
            return back()->with('error', 'Invalid or expired password reset token. Please request a new one.');
        }

        try {
            // Reset the password
            $user->resetPassword($request->password);

            return redirect()->route('login')
                ->with('success', 'Your password has been successfully reset. You can now login with your new password.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset password: ' . $e->getMessage());
        }
    }
}
