<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class About extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'header_description_ar',
        'header_description_en',
        'platform_description_ar',
        'platform_description_en',
        'our_mission_heading_ar',
        'our_mission_heading_en',
        'our_mission_description_ar',
        'our_mission_description_en',
        'our_mission_vision_description_ar',
        'our_mission_vision_description_en',
        'our_goal_description_ar',
        'our_goal_description_en',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Ensure only one record exists
        static::creating(function ($about) {
            if (static::count() > 0) {
                return false;
            }
        });
    }

    public function registerMediaCollections(): void
    {
        // Header Section - Single main image
        $this->addMediaCollection('main_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
        
        // Platform Overview - 4 images
        $this->addMediaCollection('platform_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
        
        // Our Goals - 3 images
        $this->addMediaCollection('goal_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // Helper methods for getting images
    public function getMainImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('main_image');
    }

    public function getPlatformImagesAttribute()
    {
        return $this->getMedia('platform_images');
    }

    public function getGoalImagesAttribute()
    {
        return $this->getMedia('goal_images');
    }

    // Multilingual accessors
    public function getHeaderDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->header_description_ar : $this->header_description_en;
    }

    public function getPlatformDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->platform_description_ar : $this->platform_description_en;
    }

    public function getOurMissionHeadingAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->our_mission_heading_ar : $this->our_mission_heading_en;
    }

    public function getOurMissionDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->our_mission_description_ar : $this->our_mission_description_en;
    }

    public function getOurMissionVisionDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->our_mission_vision_description_ar : $this->our_mission_vision_description_en;
    }

    public function getOurGoalDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->our_goal_description_ar : $this->our_goal_description_en;
    }
}
