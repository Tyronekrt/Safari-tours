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
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone' => ['nullable', 'string', 'max:20'],
                'country' => ['nullable', 'string', 'max:100'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'country' => $request->country,
            ]);

            // Assign customer role
            $user->assignRole('customer');

            // Generate verification token and send email
            $verificationToken = $user->generateVerificationToken();
            $verificationUrl = route('verification.verify', ['token' => $verificationToken]);

            Mail::to($user->email)->send(new EmailVerification($user, $verificationUrl));

            return redirect()->route('verification.notice')
                ->with('success', 'Registration successful! Please check your email to verify your account.');
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
