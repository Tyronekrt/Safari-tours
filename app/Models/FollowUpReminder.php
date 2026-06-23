<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpReminder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enquiry_id',
        'reminder_date',
        'reminder_time',
        'notes',
        'status',
        'completed',
        'completed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reminder_date' => 'date',
        'reminder_time' => 'datetime',
        'completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    /**
     * Get the enquiry that owns the reminder.
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }
}
