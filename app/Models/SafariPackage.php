<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SafariPackage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'featured_image',
        'short_desc',
        'full_desc',
        'duration',
        'price',
        'currency',
        'location',
        'highlights',
        'inclusions',
        'exclusions',
        'itinerary',
        'is_featured',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'enquiries_count',
        'featured_until'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'highlights' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'itinerary' => 'array',
        'published_at' => 'datetime',
        'featured_until' => 'datetime',
    ];

    /**
     * Get the category that owns the package.
     */
    public function category()
    {
        return $this->belongsTo(PackageCategory::class);
    }

    /**
     * The destinations that belong to the package.
     */
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'package_destination', 'package_id', 'destination_id')
                    ->withPivot('display_order')
                    ->orderBy('display_order');
    }

    /**
     * Get the enquiries for the package.
     */
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Scope a query to only include published packages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured packages.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where(function($q) {
                         $q->whereNull('featured_until')
                           ->orWhere('featured_until', '>', now());
                     });
    }
}
