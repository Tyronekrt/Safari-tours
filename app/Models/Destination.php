<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'featured_image',
        'country',
        'region',
        'latitude',
        'longitude',
        'best_time_to_visit',
        'wildlife',
        'activities',
        'gallery',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'views_count'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'wildlife' => 'array',
        'activities' => 'array',
        'gallery' => 'array',
    ];

    /**
     * The packages that belong to the destination.
     */
    public function packages()
    {
        return $this->belongsToMany(SafariPackage::class, 'package_destination', 'destination_id', 'package_id')
                    ->withPivot('display_order')
                    ->orderBy('display_order');
    }

    /**
     * Scope a query to only include active destinations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured destinations.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
