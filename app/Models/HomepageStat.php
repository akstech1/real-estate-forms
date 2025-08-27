<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_1_heading_en',
        'section_1_heading_ar',
        'section_1_count',
        'section_2_heading_en',
        'section_2_heading_ar',
        'section_2_count',
        'section_3_heading_en',
        'section_3_heading_ar',
        'section_3_count',
        'section_4_heading_en',
        'section_4_heading_ar',
        'section_4_count',
    ];

    // Multilingual accessors
    public function getSection1HeadingAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->section_1_heading_ar : $this->section_1_heading_en;
    }

    public function getSection2HeadingAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->section_2_heading_ar : $this->section_2_heading_en;
    }

    public function getSection3HeadingAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->section_3_heading_ar : $this->section_3_heading_en;
    }

    public function getSection4HeadingAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->section_4_heading_ar : $this->section_4_heading_en;
    }
}

