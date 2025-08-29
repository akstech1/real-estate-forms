<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    use ApiResponseTrait;
    /**
     * Get Contact information with language support
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

            // Get Contact Us data
            $contactUs = ContactUs::first();
            if (!$contactUs) {
                return $this->errorResponse('Contact information not found', 404);
            }

            // Get Social Media Links
            $socialMediaLinks = $contactUs->socialMediaLinks;

            // Prepare response data
            $data = [
                'contact_info' => [
                    'location_address' => $language === 'ar' ? $contactUs->address_ar : $contactUs->address_en,
                    'email' => $contactUs->email,
                    'phone_number' => $contactUs->phone_number,
                ],
                'social_media' => $socialMediaLinks->map(function ($link) {
                    return [
                        'title' => $link->name,
                        'link' => $link->link,
                        'image' => $link->getFirstMediaUrl('logo') ?: null,
                    ];
                })->toArray(),
                'map' => [
                    'latitude' => (float) $contactUs->latitude,
                    'longitude' => (float) $contactUs->longitude,
                ],
            ];

            return $this->successResponse($data, 'Request processed successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('Internal server error: ' . $e->getMessage(), 500);
        }
    }
}
