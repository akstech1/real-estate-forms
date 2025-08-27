<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name_en' => 'John Smith',
                'name_ar' => 'جون سميث',
                'short_description_en' => 'Excellent service and professional team. Highly recommended for anyone looking for quality real estate solutions.',
                'short_description_ar' => 'خدمة ممتازة وفريق محترف. أوصي بشدة لأي شخص يبحث عن حلول عقارية عالية الجودة.',
                'rating' => 5.0,
                'is_active' => true,
            ],
            [
                'name_en' => 'Sarah Johnson',
                'name_ar' => 'سارة جونسون',
                'short_description_en' => 'The team was very helpful and made the entire process smooth and stress-free.',
                'short_description_ar' => 'كان الفريق مفيدًا جدًا وجعل العملية بأكملها سلسة وخالية من التوتر.',
                'rating' => 4.5,
                'is_active' => true,
            ],
            [
                'name_en' => 'Ahmed Hassan',
                'name_ar' => 'أحمد حسن',
                'short_description_en' => 'Outstanding experience with this company. They truly understand customer needs.',
                'short_description_ar' => 'تجربة رائعة مع هذه الشركة. إنهم يفهمون حقًا احتياجات العملاء.',
                'rating' => 5.0,
                'is_active' => true,
            ],
            [
                'name_en' => 'Maria Garcia',
                'name_ar' => 'ماريا غارسيا',
                'short_description_en' => 'Professional, reliable, and trustworthy. I would definitely work with them again.',
                'short_description_ar' => 'محترفون وموثوقون وجديرون بالثقة. بالتأكيد سأعمل معهم مرة أخرى.',
                'rating' => 4.0,
                'is_active' => true,
            ],
            [
                'name_en' => 'David Wilson',
                'name_ar' => 'ديفيد ويلسون',
                'short_description_en' => 'Great communication throughout the process and excellent results.',
                'short_description_ar' => 'تواصل رائع طوال العملية ونتائج ممتازة.',
                'rating' => 4.5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
