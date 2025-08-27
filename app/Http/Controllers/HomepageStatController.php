<?php

namespace App\Http\Controllers;

use App\Models\HomepageStat;
use Illuminate\Http\Request;

class HomepageStatController extends Controller
{
    /**
     * Show the form for editing the homepage stats.
     */
    public function edit()
    {
        $stats = HomepageStat::first();
        
        if (!$stats) {
            $stats = HomepageStat::create([
                'section_1_heading_en' => '15,000+ Active Users',
                'section_1_heading_ar' => 'مستخدم نشط 15000+',
                'section_1_count' => '15,000+',
                'section_2_heading_en' => '11 Years of Experience',
                'section_2_heading_ar' => 'من الخبرة 11 سنة',
                'section_2_count' => '11',
                'section_3_heading_en' => '800+ Listed Properties',
                'section_3_heading_ar' => 'عقار مدرج 800+',
                'section_3_count' => '800+',
                'section_4_heading_en' => '20+ Trusted Partnerships',
                'section_4_heading_ar' => 'شراكة معتمدة 20+',
                'section_4_count' => '20+',
            ]);
        }
        
        return view('admin.homepage-stats.edit', compact('stats'));
    }

    /**
     * Update the homepage stats.
     */
    public function update(Request $request)
    {
        $request->validate([
            'section_1_heading_en' => 'required|string|max:255',
            'section_1_heading_ar' => 'required|string|max:255',
            'section_1_count' => 'required|string|max:255',
            'section_2_heading_en' => 'required|string|max:255',
            'section_2_heading_ar' => 'required|string|max:255',
            'section_2_count' => 'required|string|max:255',
            'section_3_heading_en' => 'required|string|max:255',
            'section_3_heading_ar' => 'required|string|max:255',
            'section_3_count' => 'required|string|max:255',
            'section_4_heading_en' => 'required|string|max:255',
            'section_4_heading_ar' => 'required|string|max:255',
            'section_4_count' => 'required|string|max:255',
        ], [
            'section_1_heading_en.required' => 'Section 1 heading (English) is required.',
            'section_1_heading_ar.required' => 'Section 1 heading (Arabic) is required.',
            'section_1_count.required' => 'Section 1 count is required.',
            'section_2_heading_en.required' => 'Section 2 heading (English) is required.',
            'section_2_heading_ar.required' => 'Section 2 heading (Arabic) is required.',
            'section_2_count.required' => 'Section 2 count is required.',
            'section_3_heading_en.required' => 'Section 3 heading (English) is required.',
            'section_3_heading_ar.required' => 'Section 3 heading (Arabic) is required.',
            'section_3_count.required' => 'Section 3 count is required.',
            'section_4_heading_en.required' => 'Section 4 heading (English) is required.',
            'section_4_heading_ar.required' => 'Section 4 heading (Arabic) is required.',
            'section_4_count.required' => 'Section 4 count is required.',
        ]);

        $stats = HomepageStat::firstOrCreate([]);
        
        $stats->update($request->all());

        return redirect()->route('dashboard.homepage-stats.edit')->with('success', 'Homepage stats updated successfully!');
    }
}
