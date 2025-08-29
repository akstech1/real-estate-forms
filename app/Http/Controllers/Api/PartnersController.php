<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PartnersController extends Controller
{
    use ApiResponseTrait;
    /**
     * Get Partners information with language support
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

            // Get Partners data (only active ones)
            $partners = Partner::where('is_active', true)
                              ->latest()
                              ->get();

            // Prepare response data
            $data = $partners->map(function ($partner) use ($language) {
                return [
                    'title' => $language === 'ar' ? $partner->title_ar : $partner->title_en,
                    'short_description' => $language === 'ar' ? $partner->short_description_ar : $partner->short_description_en,
                    'background_colour' => $partner->background_colour,
                    'website_link' => $partner->website_link,
                    'image' => $partner->getFirstMediaUrl('logo') ?: null,
                ];
            })->toArray();

            return $this->successResponse($data, 'Request processed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
