<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Link;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'title_en' => 'Home',
                'title_ar' => 'الرئيسية',
                'url' => 'https://example.com/home',
                'is_active' => true,
            ],
            [
                'title_en' => 'About Us',
                'title_ar' => 'من نحن',
                'url' => 'https://example.com/about',
                'is_active' => true,
            ],
            [
                'title_en' => 'Services',
                'title_ar' => 'الخدمات',
                'url' => 'https://example.com/services',
                'is_active' => true,
            ],
            [
                'title_en' => 'Contact',
                'title_ar' => 'اتصل بنا',
                'url' => 'https://example.com/contact',
                'is_active' => true,
            ],
        ];

        foreach ($links as $linkData) {
            Link::create($linkData);
        }
    }
}


