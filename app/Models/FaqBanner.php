<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FaqBanner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        // No fillable fields needed since we only store media
    ];

    protected $casts = [
        // No casts needed
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getBannerImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('banner_image');
    }

    // We only need one record, but don't prevent creation if needed
}
