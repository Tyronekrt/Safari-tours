<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['nullable', 'string', 'max:20'],
                'country' => ['nullable', 'string', 'max:100'],
            ], [
                'email.unique' => 'The email has already been taken.'
            ]);

            // Check if there's a soft-deleted user with this email and permanently delete them
            $deletedUser = User::onlyTrashed()->where('email', $request->email)->first();
            if ($deletedUser) {
                $deletedUser->forceDelete();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'country' => $request->country,
            ]);

            // Assign customer role
            $user->assignRole('customer');

            // Generate verification code and send email
            $verificationCode = $user->generateVerificationCode();

            Mail::to($user->email)->send(new EmailVerification($user, $verificationCode));

            return redirect()->route('verification.code')
                ->with('success', 'Registration successful! Please check your email for the verification code.')
                ->with('user_email', $user->email);
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
