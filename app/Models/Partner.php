<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Partner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title_en',
        'title_ar',
        'short_description_en',
        'short_description_ar',
        'background_colour',
    ];

    protected $casts = [
        'background_colour' => 'string',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo');
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getShortDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->short_description_ar : $this->short_description_en;
    }
}
