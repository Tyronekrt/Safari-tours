<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'avatar',
        'is_active',
        'verification_token',
        'password_reset_token',
        'password_reset_expires_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_reset_expires_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    /**
     * Get the enquiries for the user.
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Get the assigned enquiries for the user.
     */
    public function assignedEnquiries()
    {
        return $this->hasMany(Enquiry::class, 'assigned_to');
    }

    /**
     * Get the enquiry notes for the user.
     */
    public function enquiryNotes()
    {
        return $this->hasMany(EnquiryNote::class);
    }

    /**
     * Get the status changes made by the user.
     */
    public function statusChanges()
    {
        return $this->hasMany(EnquiryStatusHistory::class, 'changed_by');
    }

    /**
     * Generate a verification token for the user.
     */
    public function generateVerificationToken()
    {
        $this->verification_token = \Str::random(60);
        $this->save();
        return $this->verification_token;
    }

    /**
     * Verify the user's email.
     */
    public function verifyEmail()
    {
        $this->email_verified_at = now();
        $this->verification_token = null;
        $this->save();
    }

    /**
     * Check if the user is verified.
     */
    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Generate a password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Str::random(60);
        $this->password_reset_expires_at = now()->addHours(1);
        $this->save();
        return $this->password_reset_token;
    }

    /**
     * Check if password reset token is valid.
     */
    public function isPasswordResetTokenValid($token)
    {
        return $this->password_reset_token === $token && $this->password_reset_expires_at > now();
    }

    /**
     * Reset the password.
     */
    public function resetPassword($newPassword)
    {
        $this->password = \Hash::make($newPassword);
        $this->password_reset_token = null;
        $this->password_reset_expires_at = null;
        $this->save();
    }
}
