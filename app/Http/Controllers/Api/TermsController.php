<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\Terms;
use App\Models\TermsBanner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TermsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Get Terms & Conditions information with language support
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get language from header, default to English
            $language = $request->header('Accept-Language', 'en');
            $language = in_array($language, ['en', 'ar']) ? $language : 'en';

            // Get Terms Banner data
            $termsBanner = TermsBanner::first();

            // Get Terms & Conditions data (only active ones)
            $terms = Terms::where('is_active', true)
                         ->get();

            // Prepare response data
            $data = [
                'banner_image' => $termsBanner ? $termsBanner->getFirstMediaUrl('banner_image') : null,
                'terms_and_conditions' => $terms->map(function ($term) use ($language) {
                    return [
                        'heading' => $language === 'ar' ? $term->heading_ar : $term->heading_en,
                        'description' => $language === 'ar' ? $term->description_ar : $term->description_en,
                    ];
                })->toArray(),
            ];

            return $this->successResponse($data, 'Request processed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
