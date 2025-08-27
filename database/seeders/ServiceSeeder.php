<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title_en' => 'Real Estate Consulting',
                'title_ar' => 'استشارات العقارات',
                'short_description_en' => 'Professional real estate consulting services to help you make informed decisions about property investments.',
                'short_description_ar' => 'خدمات استشارات عقارية احترافية لمساعدتك في اتخاذ قرارات مدروسة حول الاستثمارات العقارية.',
                'is_active' => true,
            ],
            [
                'title_en' => 'Property Management',
                'title_ar' => 'إدارة العقارات',
                'short_description_en' => 'Comprehensive property management services including tenant screening, maintenance, and financial reporting.',
                'short_description_ar' => 'خدمات إدارة عقارية شاملة تشمل فحص المستأجرين والصيانة والتقارير المالية.',
                'is_active' => true,
            ],
            [
                'title_en' => 'Investment Advisory',
                'title_ar' => 'الاستشارات الاستثمارية',
                'short_description_en' => 'Expert investment advisory services to maximize your real estate portfolio returns.',
                'short_description_ar' => 'خدمات استشارات استثمارية متخصصة لتعظيم عوائد محفظتك العقارية.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
