<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\About;
use App\Models\Service;
use App\Models\HomepageStat;
use App\Models\Partner;
use App\Models\Link;
use App\Models\Testimonial;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomePageController extends Controller
{
    /**
     * Get Home Page data with all sections
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

            // Get all sections data
            $banners = Banner::where('is_active', true)->orderBy('id', 'asc')->get();
            $about = About::first();
            $services = Service::where('is_active', true)->orderBy('id', 'asc')->get();
            $stats = HomepageStat::get();
            $partners = Partner::where('is_active', true)->orderBy('id', 'asc')->get();
            $links = Link::where('is_active', true)->orderBy('id', 'asc')->get();
            $testimonials = Testimonial::where('is_active', true)->orderBy('created_at', 'desc')->get();
            $faqs = Faq::where('is_active', true)->orderBy('id', 'asc')->get();

            // Prepare response data
            $data = [
                'banners' => $banners->map(function ($banner) use ($language) {
                    return [
                        'id' => $banner->id,
                        'title' => $language === 'ar' ? $banner->title_ar : $banner->title_en,
                        'subtitle' => $language === 'ar' ? $banner->subtitle_ar : $banner->subtitle_en,
                        'description' => $language === 'ar' ? $banner->description_ar : $banner->description_en,
                        'image_url' => $banner->getFirstMediaUrl('banner_image') ?: null,
                        'button_text' => $language === 'ar' ? $banner->button_text_ar : $banner->button_text_en,
                        'button_link' => $banner->button_link,
                    ];
                })->toArray(),

                'about_us' => $about ? [
                    'home_short_description' => $language === 'ar' ? $about->home_short_description_ar : $about->home_short_description_en,
                    'logo' => $about->getFirstMediaUrl('home_logo') ?: null,
                    'home_button_text' => $language === 'ar' ? $about->home_button_text_ar : $about->home_button_text_en,
                    'home_button_link' => $about->home_button_link,
                    'count' => $about->count,
                    'count_heading' => $language === 'ar' ? $about->count_heading_ar : $about->count_heading_en,
                    'count_description' => $language === 'ar' ? $about->count_description_ar : $about->count_description_en,
                ] : null,

                'services' => $services->map(function ($service) use ($language) {
                    return [
                        'id' => $service->id,
                        'title' => $language === 'ar' ? $service->title_ar : $service->title_en,
                        'short_description' => $language === 'ar' ? $service->short_description_ar : $service->short_description_en,
                        'description' => $language === 'ar' ? $service->description_ar : $service->description_en,
                        'image_url' => $service->getFirstMediaUrl('main_image') ?: null,
                    ];
                })->toArray(),

                'stats' => $stats->map(function ($stat) use ($language) {
                    return [
                        'id' => $stat->id,
                        'section_1_heading' => $language === 'ar' ? $stat->section_1_heading_ar : $stat->section_1_heading_en,
                        'section_1_count' => $stat->section_1_count,
                        'section_2_heading' => $language === 'ar' ? $stat->section_2_heading_ar : $stat->section_2_heading_en,
                        'section_2_count' => $stat->section_2_count,
                        'section_3_heading' => $language === 'ar' ? $stat->section_3_heading_ar : $stat->section_3_heading_en,
                        'section_3_count' => $stat->section_3_count,
                        'section_4_heading' => $language === 'ar' ? $stat->section_4_heading_ar : $stat->section_4_heading_en,
                        'section_4_count' => $stat->section_4_count,
                    ];
                })->toArray(),

                'partners' => $partners->map(function ($partner) use ($language) {
                    return [
                        'id' => $partner->id,
                        'title' => $language === 'ar' ? $partner->title_ar : $partner->title_en,
                        'short_description' => $language === 'ar' ? $partner->short_description_ar : $partner->short_description_en,
                        'logo_url' => $partner->getFirstMediaUrl('logo') ?: null,
                        'background_color' => $partner->background_colour,
                        'website_link' => $partner->website_link,
                    ];
                })->toArray(),

                'links' => $links->map(function ($link) use ($language) {
                    return [
                        'id' => $link->id,
                        'title' => $language === 'ar' ? $link->title_ar : $link->title_en,
                        'logo' => $link->getFirstMediaUrl('logo') ?: null,
                    ];
                })->toArray(),

                'testimonials' => $testimonials->map(function ($testimonial) use ($language) {
                    return [
                        'id' => $testimonial->id,
                        'name' => $language === 'ar' ? $testimonial->name_ar : $testimonial->name_en,
                        'short_description' => $language === 'ar' ? $testimonial->short_description_ar : $testimonial->short_description_en,
                        'rating' => $testimonial->rating,
                        'image_url' => $testimonial->getFirstMediaUrl('image') ?: null,
                        'created_at' => $testimonial->created_at->format('Y-m-d H:i:s'),
                    ];
                })->toArray(),

                'faqs' => $faqs->map(function ($faq) use ($language) {
                    return [
                        'id' => $faq->id,
                        'question' => $language === 'ar' ? $faq->question_ar : $faq->question_en,
                        'answer' => $language === 'ar' ? $faq->answer_ar : $faq->answer_en,
                    ];
                })->toArray(),
            ];

            return $this->successResponse($data, 'Home page data retrieved successfully.');

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
