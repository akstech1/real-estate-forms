<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Terms::orderBy('id', 'desc')->get();
        return view('admin.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'terms' => 'required|array|min:1',
            'terms.*.heading_en' => 'required|string|max:500',
            'terms.*.heading_ar' => 'required|string|max:500',
            'terms.*.description_en' => 'required|string',
            'terms.*.description_ar' => 'required|string',
        ], [
            'terms.required' => 'At least one term is required.',
            'terms.min' => 'At least one term is required.',
            'terms.*.heading_en.required' => 'Heading (English) is required for all terms.',
            'terms.*.heading_ar.required' => 'Heading (Arabic) is required for all terms.',
            'terms.*.description_en.required' => 'Description (English) is required for all terms.',
            'terms.*.description_ar.required' => 'Description (Arabic) is required for all terms.',
            'terms.*.heading_en.max' => 'Heading (English) cannot exceed 500 characters.',
            'terms.*.heading_ar.max' => 'Heading (Arabic) cannot exceed 500 characters.',
        ]);

        $terms = $request->input('terms');
        $createdCount = 0;

        foreach ($terms as $index => $termData) {
            if (!empty($termData['heading_en']) && !empty($termData['description_en'])) {
                Terms::create([
                    'heading_en' => $termData['heading_en'],
                    'heading_ar' => $termData['heading_ar'],
                    'description_en' => $termData['description_en'],
                    'description_ar' => $termData['description_ar'],
                    'is_active' => true,
                ]);
                $createdCount++;
            }
        }

        if ($createdCount > 0) {
            return redirect()->route('dashboard.terms.index')
                ->with('success', "Successfully created {$createdCount} term(s)!");
        }

        return redirect()->route('dashboard.terms.create')
            ->with('error', 'No valid terms were created. Please check your input.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Terms $term)
    {
        return view('admin.terms.show', compact('term'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terms $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terms $term)
    {
        $request->validate([
            'heading_en' => 'required|string|max:500',
            'heading_ar' => 'required|string|max:500',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'is_active' => 'boolean',
        ], [
            'heading_en.required' => 'Heading (English) is required.',
            'heading_ar.required' => 'Heading (Arabic) is required.',
            'description_en.required' => 'Description (English) is required.',
            'description_ar.required' => 'Description (Arabic) is required.',
            'heading_en.max' => 'Heading (English) cannot exceed 500 characters.',
            'heading_ar.max' => 'Heading (Arabic) cannot exceed 500 characters.',
        ]);

        $term->update([
            'heading_en' => $request->heading_en,
            'heading_ar' => $request->heading_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.terms.index')
            ->with('success', 'Terms & Conditions updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terms $term)
    {
        $term->delete();
        return redirect()->route('dashboard.terms.index')
            ->with('success', 'Terms & Conditions deleted successfully!');
    }

    /**
     * Toggle Terms status.
     */
    public function toggleStatus(Terms $term)
    {
        $term->update(['is_active' => !$term->is_active]);
        return redirect()->route('dashboard.terms.index')
            ->with('success', 'Terms & Conditions status updated successfully!');
    }
}
