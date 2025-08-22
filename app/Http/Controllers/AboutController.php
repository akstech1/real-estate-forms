<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $about = About::first();

        if (!$about) {
            // Create default about record if none exists
            $about = About::create([
                'header_description_ar' => 'مرحباً بكم في شركتنا',
                'header_description_en' => 'Welcome to our company',
                'platform_description_ar' => 'نظرة عامة على منصتنا',
                'platform_description_en' => 'Overview of our platform',
                'our_mission_heading_ar' => 'مهمتنا',
                'our_mission_heading_en' => 'Our Mission',
                'our_mission_description_ar' => 'نحن ملتزمون بتقديم خدمة ممتازة',
                'our_mission_description_en' => 'We are committed to providing excellent service',
                'our_mission_vision_description_ar' => 'رؤيتنا هي أن نصبح المزود الرائد في صناعتنا',
                'our_mission_vision_description_en' => 'Our vision is to become the leading provider in our industry',
                'our_goal_description_ar' => 'أهدافنا',
                'our_goal_description_en' => 'Our Goals',
            ]);
        }

        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the header section.
     */
    public function updateHeader(Request $request)
    {
        $request->validate([
            'header_description_ar' => 'required|string',
            'header_description_en' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'header_description_ar.required' => 'Header description (Arabic) is required.',
            'header_description_en.required' => 'Header description (English) is required.',
            'main_image.image' => 'Main header image must be a valid image file.',
            'main_image.mimes' => 'Main header image must be JPEG, PNG, JPG, or WebP format.',
            'main_image.max' => 'Main header image must be less than 2MB.',
        ]);

        $about = About::firstOrCreate([]);
        
        $about->update([
            'header_description_ar' => $request->header_description_ar,
            'header_description_en' => $request->header_description_en,
        ]);

        // Handle main image
        if ($request->hasFile('main_image')) {
            $about->clearMediaCollection('main_image');
            $about->addMediaFromRequest('main_image')
                ->toMediaCollection('main_image');
        }

        return redirect()->route('dashboard.home.about')->with('success', 'Header section updated successfully!');
    }

    /**
     * Update the platform overview section.
     */
    public function updatePlatform(Request $request)
    {
        $request->validate([
            'platform_description_ar' => 'required|string',
            'platform_description_en' => 'required|string',
            'platform_images' => 'nullable|array|max:4',
            'platform_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'platform_description_ar.required' => 'Platform description (Arabic) is required.',
            'platform_description_en.required' => 'Platform description (English) is required.',
            'platform_images.max' => 'Platform Overview can only have a maximum of 4 images.',
            'platform_images.*.image' => 'Platform images must be valid image files.',
            'platform_images.*.mimes' => 'Platform images must be JPEG, PNG, JPG, or WebP format.',
            'platform_images.*.max' => 'Each platform image must be less than 2MB.',
        ]);

        $about = About::firstOrCreate([]);
        
        $about->update([
            'platform_description_ar' => $request->platform_description_ar,
            'platform_description_en' => $request->platform_description_en,
        ]);

        // Handle platform images
        if ($request->hasFile('platform_images')) {
            $about->clearMediaCollection('platform_images');
            foreach ($request->file('platform_images') as $image) {
                $about->addMedia($image)
                    ->toMediaCollection('platform_images');
            }
        }

        return redirect()->route('dashboard.home.about')->with('success', 'Platform Overview section updated successfully!');
    }

    /**
     * Update the mission section.
     */
    public function updateMission(Request $request)
    {
        $request->validate([
            'our_mission_heading_ar' => 'required|string|max:255',
            'our_mission_heading_en' => 'required|string|max:255',
            'our_mission_description_ar' => 'required|string',
            'our_mission_description_en' => 'required|string',
            'our_mission_vision_description_ar' => 'required|string',
            'our_mission_vision_description_en' => 'required|string',
        ], [
            'our_mission_heading_ar.required' => 'Mission heading (Arabic) is required.',
            'our_mission_heading_en.required' => 'Mission heading (English) is required.',
            'our_mission_heading_ar.max' => 'Mission heading (Arabic) cannot exceed 255 characters.',
            'our_mission_heading_en.max' => 'Mission heading (English) cannot exceed 255 characters.',
            'our_mission_description_ar.required' => 'Mission description (Arabic) is required.',
            'our_mission_description_en.required' => 'Mission description (English) is required.',
            'our_mission_vision_description_ar.required' => 'Mission vision description (Arabic) is required.',
            'our_mission_vision_description_en.required' => 'Mission vision description (English) is required.',
        ]);

        $about = About::firstOrCreate([]);
        
        $about->update([
            'our_mission_heading_ar' => $request->our_mission_heading_ar,
            'our_mission_heading_en' => $request->our_mission_heading_en,
            'our_mission_description_ar' => $request->our_mission_description_ar,
            'our_mission_description_en' => $request->our_mission_description_en,
            'our_mission_vision_description_ar' => $request->our_mission_vision_description_ar,
            'our_mission_vision_description_en' => $request->our_mission_vision_description_en,
        ]);

        return redirect()->route('dashboard.home.about')->with('success', 'Mission section updated successfully!');
    }

    /**
     * Update the goals section.
     */
    public function updateGoals(Request $request)
    {
        $request->validate([
            'our_goal_description_ar' => 'required|string',
            'our_goal_description_en' => 'required|string',
            'goal_images' => 'nullable|array|max:3',
            'goal_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'our_goal_description_ar.required' => 'Goal description (Arabic) is required.',
            'our_goal_description_en.required' => 'Goal description (English) is required.',
            'goal_images.max' => 'Our Goals can only have a maximum of 3 images.',
            'goal_images.*.image' => 'Goal images must be valid image files.',
            'goal_images.*.mimes' => 'Goal images must be JPEG, PNG, JPG, or WebP format.',
            'goal_images.*.max' => 'Each goal image must be less than 2MB.',
        ]);

        $about = About::firstOrCreate([]);
        
        $about->update([
            'our_goal_description_ar' => $request->our_goal_description_ar,
            'our_goal_description_en' => $request->our_goal_description_en,
        ]);

        // Handle goal images
        if ($request->hasFile('goal_images')) {
            $about->clearMediaCollection('goal_images');
            foreach ($request->file('goal_images') as $image) {
                $about->addMedia($image)
                    ->toMediaCollection('goal_images');
            }
        }

        return redirect()->route('dashboard.home.about')->with('success', 'Goals section updated successfully!');
    }

    /**
     * Update the specified resource in storage.
     * @deprecated Use individual section update methods instead
     */
    public function update(Request $request)
    {
        // This method is kept for backward compatibility but deprecated
        // Use individual section update methods instead
        return redirect()->route('dashboard.home.about')->with('info', 'Please use individual section update buttons.');
    }
}
