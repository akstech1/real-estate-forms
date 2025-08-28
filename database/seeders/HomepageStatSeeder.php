<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageStat;

class HomepageStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomepageStat::create([
            'section_1_heading_en' => 'Active Users',
            'section_1_heading_ar' => 'مستخدم نشط',
            'section_1_count' => '15000+',
            'section_2_heading_en' => 'Years of Experience',
            'section_2_heading_ar' => 'من الخبرة سنة',
            'section_2_count' => '11+',
            'section_3_heading_en' => '800+ Listed Properties',
            'section_3_heading_ar' => 'عقار مدرج',
            'section_3_count' => '800+',
            'section_4_heading_en' => 'Trusted Partnerships',
            'section_4_heading_ar' => 'شراكة معتمدة',
            'section_4_count' => '20+',
        ]);
    }
}


