<?php

namespace App\Http\Controllers;

use App\Models\FaqBanner;
use Illuminate\Http\Request;

class FaqBannerController extends Controller
{
    /**
     * Show the form for editing the FAQ banner.
     */
    public function edit()
    {
        $faqBanner = FaqBanner::first();
        
        return view('admin.faqs.banner', compact('faqBanner'));
    }

    /**
     * Update the FAQ banner in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'banner_image.required' => 'Banner image is required.',
            'banner_image.image' => 'Banner image must be a valid image file.',
            'banner_image.mimes' => 'Banner image must be JPEG, PNG, JPG, or WebP format.',
            'banner_image.max' => 'Banner image must be less than 2MB.',
        ]);

        $faqBanner = FaqBanner::first();
        
        if (!$faqBanner) {
            $faqBanner = new FaqBanner();
            $faqBanner->save(); // Save to database first to get an ID
        }

        if ($request->hasFile('banner_image')) {
            $faqBanner->clearMediaCollection('banner_image');
            $faqBanner->addMediaFromRequest('banner_image')
                ->toMediaCollection('banner_image');
        }

        return redirect()->route('dashboard.faqs.banner.edit')
            ->with('success', 'FAQ banner updated successfully!');
    }
}
