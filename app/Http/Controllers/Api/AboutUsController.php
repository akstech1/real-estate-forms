<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\About;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AboutUsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Get About Us information with language support
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

            // Get About Us data
            $about = About::first();
            if (!$about) {
                return $this->errorResponse('About Us information not found', 404);
            }

            // Get Partners data
            $partners = Partner::where('is_active', true)->latest()->get();

            // Prepare response data
            $data = [
                'headers_section' => [
                    'header_description' => $language === 'ar' ? $about->header_description_ar : $about->header_description_en,
                    'image' => $about->getFirstMediaUrl('main_image') ?: null,
                ],
                'platform_overview' => [
                    'platform_description' => $language === 'ar' ? $about->platform_description_ar : $about->platform_description_en,
                    'images' => $about->getMedia('platform_images')->map(function ($media) {
                        return $media->getUrl();
                    })->toArray(),
                ],
                'our_mission' => [
                    'mission_heading' => $language === 'ar' ? $about->our_mission_heading_ar : $about->our_mission_heading_en,
                    'mission_description' => $language === 'ar' ? $about->our_mission_description_ar : $about->our_mission_description_en,
                    'vision_description' => $language === 'ar' ? $about->our_mission_vision_description_ar : $about->our_mission_vision_description_en,
                    'static_titles' => [
                        'mission' => $language === 'ar' ? 'مهمتنا' : 'Our Mission',
                        'vision' => $language === 'ar' ? 'رؤيتنا' : 'Our Vision',
                    ],
                ],
                'our_goals' => [
                    'our_goal_description' => $language === 'ar' ? $about->our_goal_description_ar : $about->our_goal_description_en,
                    'images' => $about->getMedia('goal_images')->map(function ($media) {
                        return $media->getUrl();
                    })->toArray(),
                ],
                'our_partners' => [
                    'static_title_1' => 'Our Mission',
                    'static_title_2' => 'Our Vision',
                    'partners' => $partners->map(function ($partner) use ($language) {
                        return [
                            'name' => $language === 'ar' ? $partner->title_ar : $partner->title_en,
                            'short_description' => $language === 'ar' ? $partner->short_description_ar : $partner->short_description_en,
                            'logo_url' => $partner->getFirstMediaUrl('logo') ?: null,
                            'background_color' => $partner->background_colour,
                            'website_link' => $partner->website_link,
                        ];
                    })->toArray(),
                ],
            ];

            return $this->successResponse($data, 'Request processed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
