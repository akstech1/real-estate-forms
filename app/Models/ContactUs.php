<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_en',
        'address_ar',
        'email',
        'phone_number',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the social media links for this contact us.
     */
    public function socialMediaLinks()
    {
        return $this->belongsToMany(SocialMediaLink::class, 'contact_us_social_media_link')
                    ->withTimestamps();
    }

    /**
     * Get the address attribute based on current locale.
     */
    public function getAddressAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->address_ar : $this->address_en;
    }

    /**
     * Boot method to ensure only one record exists.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contactUs) {
            // Check if a record already exists
            if (static::count() > 0) {
                return false;
            }
        });
    }
}
