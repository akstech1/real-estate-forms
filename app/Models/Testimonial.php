<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name_en',
        'name_ar',
        'short_description_en',
        'short_description_ar',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('created_at', 'desc');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    // Multilingual accessors
    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getShortDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->short_description_ar : $this->short_description_en;
    }

    // Rating validation
    public function setRatingAttribute($value)
    {
        $this->attributes['rating'] = max(1.0, min(5.0, (float) $value));
    }
}
