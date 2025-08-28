<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::orderBy('created_at', 'desc')->get();
        return view('admin.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'Title (English) is required.',
            'title_ar.required' => 'Title (Arabic) is required.',
            'url.required' => 'URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'url.max' => 'URL must be less than 500 characters.',
            'logo.required' => 'Logo is required.',
            'logo.image' => 'Logo must be a valid image file.',
            'logo.mimes' => 'Logo must be JPEG, PNG, JPG, or WebP format.',
            'logo.max' => 'Logo must be less than 2MB.',
        ]);

        $data = $request->except(['logo']);
        $data['is_active'] = $request->boolean('is_active');

        $link = Link::create($data);

        if ($request->hasFile('logo')) {
            $link->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('dashboard.links.index')->with('success', 'Link created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $link = Link::findOrFail($id);
        return view('admin.links.show', compact('link'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = Link::findOrFail($id);
        return view('admin.links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'Title (English) is required.',
            'title_ar.required' => 'Title (Arabic) is required.',
            'url.required' => 'URL is required.',
            'url.url' => 'Please enter a valid URL.',
            'url.max' => 'URL must be less than 500 characters.',
            'logo.image' => 'Logo must be a valid image file.',
            'logo.mimes' => 'Logo must be JPEG, PNG, JPG, or WebP format.',
            'logo.max' => 'Logo must be less than 2MB.',
        ]);

        $link = Link::findOrFail($id);
        
        $data = $request->except(['logo']);
        $data['is_active'] = $request->boolean('is_active');

        $link->update($data);

        if ($request->hasFile('logo')) {
            $link->clearMediaCollection('logo');
            $link->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('dashboard.links.index')->with('success', 'Link updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $link = Link::findOrFail($id);
        $link->clearMediaCollection('logo');
        $link->delete();

        return redirect()->route('dashboard.links.index')->with('success', 'Link deleted successfully!');
    }
}
