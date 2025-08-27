<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'short_description_en' => 'required|string',
            'short_description_ar' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'Title (English) is required.',
            'title_ar.required' => 'Title (Arabic) is required.',
            'short_description_en.required' => 'Short description (English) is required.',
            'short_description_ar.required' => 'Short description (Arabic) is required.',
            'main_image.required' => 'Main image is required.',
            'main_image.image' => 'Main image must be a valid image file.',
            'main_image.mimes' => 'Main image must be JPEG, PNG, JPG, or WebP format.',
            'main_image.max' => 'Main image must be less than 2MB.',
        ]);

        $data = $request->except(['main_image']);
        $data['is_active'] = $request->boolean('is_active');

        $service = Service::create($data);

        if ($request->hasFile('main_image')) {
            $service->addMediaFromRequest('main_image')
                ->toMediaCollection('main_image');
        }

        return redirect()->route('dashboard.services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'short_description_en' => 'required|string',
            'short_description_ar' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'Title (English) is required.',
            'title_ar.required' => 'Title (Arabic) is required.',
            'short_description_en.required' => 'Short description (English) is required.',
            'short_description_ar.required' => 'Short description (Arabic) is required.',
            'main_image.image' => 'Main image must be a valid image file.',
            'main_image.mimes' => 'Main image must be JPEG, PNG, JPG, or WebP format.',
            'main_image.max' => 'Main image must be less than 2MB.',
        ]);

        $service = Service::findOrFail($id);
        
        $data = $request->except(['main_image']);
        $data['is_active'] = $request->boolean('is_active');

        $service->update($data);

        if ($request->hasFile('main_image')) {
            $service->clearMediaCollection('main_image');
            $service->addMediaFromRequest('main_image')
                ->toMediaCollection('main_image');
        }

        return redirect()->route('dashboard.services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->clearMediaCollection('main_image');
        $service->delete();

        return redirect()->route('dashboard.services.index')->with('success', 'Service deleted successfully!');
    }
}
