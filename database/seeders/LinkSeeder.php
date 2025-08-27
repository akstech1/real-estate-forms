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
                'is_active' => true,
            ],
            [
                'title_en' => 'About Us',
                'title_ar' => 'من نحن',
                'is_active' => true,
            ],
            [
                'title_en' => 'Services',
                'title_ar' => 'الخدمات',
                'is_active' => true,
            ],
            [
                'title_en' => 'Contact',
                'title_ar' => 'اتصل بنا',
                'is_active' => true,
            ],
        ];

        foreach ($links as $linkData) {
            Link::create($linkData);
        }
    }
}

