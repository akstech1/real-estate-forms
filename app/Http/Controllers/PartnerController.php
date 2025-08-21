<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partners.create');
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
            'background_colour' => 'required|string|max:7',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $partner = Partner::create($request->except('logo'));

        if ($request->hasFile('logo')) {
            $partner->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('dashboard.partners.index')
            ->with('success', 'Partner created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'short_description_en' => 'required|string',
            'short_description_ar' => 'required|string',
            'background_colour' => 'required|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $partner->update($request->except('logo'));

        if ($request->hasFile('logo')) {
            $partner->clearMediaCollection('logo');
            $partner->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('dashboard.partners.index')
            ->with('success', 'Partner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('dashboard.partners.index')
            ->with('success', 'Partner deleted successfully!');
    }
}
