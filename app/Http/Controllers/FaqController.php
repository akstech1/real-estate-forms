<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'faqs' => 'required|array|min:1',
            'faqs.*.question_en' => 'required|string|max:500',
            'faqs.*.question_ar' => 'required|string|max:500',
            'faqs.*.answer_en' => 'required|string',
            'faqs.*.answer_ar' => 'required|string',
        ], [
            'faqs.required' => 'At least one FAQ is required.',
            'faqs.min' => 'At least one FAQ is required.',
            'faqs.*.question_en.required' => 'Question (English) is required for all FAQs.',
            'faqs.*.question_ar.required' => 'Question (Arabic) is required for all FAQs.',
            'faqs.*.answer_en.required' => 'Answer (English) is required for all FAQs.',
            'faqs.*.answer_ar.required' => 'Answer (Arabic) is required for all FAQs.',
            'faqs.*.question_en.max' => 'Question (English) cannot exceed 500 characters.',
            'faqs.*.question_ar.max' => 'Question (Arabic) cannot exceed 500 characters.',
        ]);

        $faqs = $request->input('faqs');
        $createdCount = 0;

        foreach ($faqs as $index => $faqData) {
            if (!empty($faqData['question_en']) && !empty($faqData['answer_en'])) {
                Faq::create([
                    'question_en' => $faqData['question_en'],
                    'question_ar' => $faqData['question_ar'],
                    'answer_en' => $faqData['answer_en'],
                    'answer_ar' => $faqData['answer_ar'],
                    'is_active' => true,
                ]);
                $createdCount++;
            }
        }

        if ($createdCount > 0) {
            return redirect()->route('dashboard.faqs.index')
                ->with('success', "Successfully created {$createdCount} FAQ(s)!");
        }

        return redirect()->route('dashboard.faqs.create')
            ->with('error', 'No valid FAQs were created. Please check your input.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question_en' => 'required|string|max:500',
            'question_ar' => 'required|string|max:500',
            'answer_en' => 'required|string',
            'answer_ar' => 'required|string',
            'is_active' => 'boolean',
        ], [
            'question_en.required' => 'Question (English) is required.',
            'question_ar.required' => 'Question (Arabic) is required.',
            'answer_en.required' => 'Answer (English) is required.',
            'answer_ar.required' => 'Answer (Arabic) is required.',
            'question_en.max' => 'Question (English) cannot exceed 500 characters.',
            'question_ar.max' => 'Question (Arabic) cannot exceed 500 characters.',
        ]);

        $faq->update([
            'question_en' => $request->question_en,
            'question_ar' => $request->question_ar,
            'answer_en' => $request->answer_en,
            'answer_ar' => $request->answer_ar,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.faqs.index')
            ->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('dashboard.faqs.index')
            ->with('success', 'FAQ deleted successfully!');
    }



    /**
     * Toggle FAQ status.
     */
    public function toggleStatus(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return redirect()->route('dashboard.faqs.index')
            ->with('success', 'FAQ status updated successfully!');
    }
}
