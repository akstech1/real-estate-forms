<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Banner store method called', ['request_data' => $request->all()]);
            
            $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'short_description_en' => 'nullable|string',
                'short_description_ar' => 'nullable|string',
                'button_text_en' => 'nullable|string|max:255',
                'button_text_ar' => 'nullable|string|max:255',
                'button_link' => 'nullable|url|max:255',
                'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'nullable|boolean'
            ]);

            $data = $request->except(['banner_image']);
            $data['is_active'] = $request->boolean('is_active');
            
            \Log::info('Creating banner with data', ['data' => $data]);

            $banner = Banner::create($data);
            
            \Log::info('Banner created successfully', ['banner_id' => $banner->id]);

            if ($request->hasFile('banner_image')) {
                \Log::info('Processing banner image');
                $banner->addMediaFromRequest('banner_image')
                    ->toMediaCollection('banner_image');
                \Log::info('Banner image processed successfully');
            }

            return redirect()->route('dashboard.banners.index')->with('success', 'Banner created successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Error creating banner', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Error creating banner: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_ar' => 'nullable|string',
            'button_text_en' => 'nullable|string|max:255',
            'button_text_ar' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $data = $request->except(['banner_image']);
        $data['is_active'] = $request->boolean('is_active');

        $banner->update($data);

        if ($request->hasFile('banner_image')) {
            $banner->clearMediaCollection('banner_image');
            $banner->addMediaFromRequest('banner_image')
                ->toMediaCollection('banner_image');
        }

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->clearMediaCollection('banner_image');
        $banner->delete();

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
