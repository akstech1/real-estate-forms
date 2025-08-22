<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqBanner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FaqsController extends Controller
{
    /**
     * Get FAQs information with language support
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

            // Get FAQ Banner data
            $faqBanner = FaqBanner::first();
            
            // Get FAQs data (only active ones)
            $faqs = Faq::where('is_active', true)
                       ->get();

            // Prepare response data
            $data = [
                'banner_image' => $faqBanner ? $faqBanner->getFirstMediaUrl('banner_image') : null,
                'faqs' => $faqs->map(function ($faq) use ($language) {
                    return [
                        'question' => $language === 'ar' ? $faq->question_ar : $faq->question_en,
                        'answer' => $language === 'ar' ? $faq->answer_ar : $faq->answer_en,
                    ];
                })->toArray(),
            ];

            return $this->successResponse($data, 'Request processed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Return success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function successResponse($data, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'error' => false,
            'message' => $message,
            'status_code' => $statusCode,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return error response
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function errorResponse(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'status_code' => $statusCode,
            'data' => [],
        ], $statusCode);
    }
}
