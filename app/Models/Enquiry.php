<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assigned_to',
        'package_id',
        'full_name',
        'email',
        'phone',
        'country',
        'adults',
        'children',
        'travel_date',
        'duration',
        'budget',
        'message',
        'status',
        'last_contacted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'travel_date' => 'date',
        'last_contacted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the enquiry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user assigned to the enquiry.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the package associated with the enquiry.
     */
    public function package()
    {
        return $this->belongsTo(SafariPackage::class);
    }

    /**
     * Get the notes for the enquiry.
     */
    public function notes()
    {
        return $this->hasMany(EnquiryNote::class);
    }

    /**
     * Get the status history for the enquiry.
     */
    public function statusHistory()
    {
        return $this->hasMany(EnquiryStatusHistory::class);
    }

    /**
     * Get the reminders for the enquiry.
     */
    public function reminders()
    {
        return $this->hasMany(FollowUpReminder::class);
    }

    /**
     * Scope a query to only include enquiries with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include enquiries assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }
}
