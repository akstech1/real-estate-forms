<?php

namespace App\Http\Controllers;

use App\Models\TermsBanner;
use Illuminate\Http\Request;

class TermsBannerController extends Controller
{
    /**
     * Show the form for editing the Terms & Conditions banner.
     */
    public function edit()
    {
        $termsBanner = TermsBanner::first();
        
        return view('admin.terms.banner', compact('termsBanner'));
    }

    /**
     * Update the Terms & Conditions banner in storage.
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

        $termsBanner = TermsBanner::first();
        
        if (!$termsBanner) {
            $termsBanner = new TermsBanner();
            $termsBanner->save(); // Save to database first to get an ID
        }

        if ($request->hasFile('banner_image')) {
            $termsBanner->clearMediaCollection('banner_image');
            $termsBanner->addMediaFromRequest('banner_image')
                ->toMediaCollection('banner_image');
        }

        return redirect()->route('dashboard.terms.banner.edit')
            ->with('success', 'Terms & Conditions banner updated successfully!');
    }
}
