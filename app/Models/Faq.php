<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_en',
        'question_ar',
        'answer_en',
        'answer_ar',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Multilingual accessors
    public function getQuestionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->question_ar : $this->question_en;
    }

    public function getAnswerAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->answer_en : $this->answer_ar;
    }

    // Scope for active FAQs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered FAQs
    public function scopeOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
