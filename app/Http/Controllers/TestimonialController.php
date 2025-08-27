<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'short_description_en' => 'required|string|max:1000',
            'short_description_ar' => 'required|string|max:1000',
            'rating' => 'required|numeric|min:1|max:5',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ], [
            'name_en.required' => 'Name (English) is required.',
            'name_ar.required' => 'Name (Arabic) is required.',
            'short_description_en.required' => 'Short description (English) is required.',
            'short_description_ar.required' => 'Short description (Arabic) is required.',
            'rating.required' => 'Rating is required.',
            'rating.numeric' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least 1.',
            'rating.max' => 'Rating cannot exceed 5.',
            'image.required' => 'Image is required.',
            'image.image' => 'Image must be a valid image file.',
            'image.mimes' => 'Image must be JPEG, PNG, JPG, or WebP format.',
            'image.max' => 'Image must be less than 2MB.',
        ]);

        $data = $request->except(['image']);
        $data['is_active'] = $request->boolean('is_active');

        $testimonial = Testimonial::create($data);

        if ($request->hasFile('image')) {
            $testimonial->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'short_description_en' => 'required|string|max:1000',
            'short_description_ar' => 'required|string|max:1000',
            'rating' => 'required|numeric|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ], [
            'name_en.required' => 'Name (English) is required.',
            'name_ar.required' => 'Name (Arabic) is required.',
            'short_description_en.required' => 'Short description (English) is required.',
            'short_description_ar.required' => 'Short description (Arabic) is required.',
            'rating.required' => 'Rating is required.',
            'rating.numeric' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least 1.',
            'rating.max' => 'Rating cannot exceed 5.',
            'image.image' => 'Image must be a valid image file.',
            'image.mimes' => 'Image must be JPEG, PNG, JPG, or WebP format.',
            'image.max' => 'Image must be less than 2MB.',
        ]);

        $data = $request->except(['image']);
        $data['is_active'] = $request->boolean('is_active');

        $testimonial->update($data);

        if ($request->hasFile('image')) {
            $testimonial->clearMediaCollection('image');
            $testimonial->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->clearMediaCollection('image');
        $testimonial->delete();

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }

    /**
     * Toggle the active status of the testimonial.
     */
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        $status = $testimonial->is_active ? 'activated' : 'deactivated';
        return redirect()->route('dashboard.testimonials.index')
            ->with('success', "Testimonial {$status} successfully!");
    }
}
