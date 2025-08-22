<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    /**
     * Show the form for editing contact information.
     */
    public function edit()
    {
        $contactUs = ContactUs::first();
        
        if (!$contactUs) {
            $contactUs = ContactUs::create([
                'address_en' => '',
                'address_ar' => '',
                'email' => '',
                'phone_number' => '',
                'latitude' => null,
                'longitude' => null,
            ]);
        }

        $socialMediaLinks = $contactUs->socialMediaLinks;

        return view('admin.contact.edit', compact('contactUs', 'socialMediaLinks'));
    }

    /**
     * Update the contact information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'address_en' => 'required|string|max:500',
            'address_ar' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'social_media_links' => 'array',
            'social_media_links.*.name' => 'required|string|max:100',
            'social_media_links.*.logo' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'social_media_links.*.link' => 'required|url|max:500',
        ]);

        $contactUs = ContactUs::first();
        
        if (!$contactUs) {
            $contactUs = new ContactUs();
        }

        $contactUs->fill($request->only([
            'address_en',
            'address_ar',
            'email',
            'phone_number',
            'latitude',
            'longitude',
        ]));
        
        $contactUs->save();

        // Handle social media links
        if ($request->has('social_media_links')) {
            // Get existing social media links
            $existingLinks = $contactUs->socialMediaLinks;
            
            // Clear existing relationships
            $contactUs->socialMediaLinks()->detach();
            
            // Process each social media link
            foreach ($request->social_media_links as $index => $linkData) {
                // Check if this is an existing link being updated
                $existingLink = $existingLinks->get($index);
                
                if ($existingLink && !isset($linkData['logo'])) {
                    // This is an existing link with no new logo - update and preserve logo
                    $existingLink->update([
                        'name' => $linkData['name'],
                        'link' => $linkData['link'],
                    ]);
                    $socialMediaLink = $existingLink;
                } else {
                    // This is either a new link or existing link with new logo
                    $socialMediaLink = SocialMediaLink::create([
                        'name' => $linkData['name'],
                        'logo' => '', // This will be empty as we're using Media Library
                        'link' => $linkData['link'],
                    ]);
                    
                    // Handle logo file upload
                    if (isset($linkData['logo']) && $linkData['logo']->isValid()) {
                        $socialMediaLink->addMediaFromRequest('social_media_links.' . $index . '.logo')
                                       ->toMediaCollection('logo');
                    }
                    
                    // If updating existing link, delete the old one
                    if ($existingLink) {
                        $existingLink->delete();
                    }
                }
                
                $contactUs->socialMediaLinks()->attach($socialMediaLink->id);
            }
        }

        return redirect()->route('dashboard.contact.edit')
                        ->with('success', 'Contact information updated successfully!');
    }

    /**
     * Delete a social media link.
     */
    public function deleteSocialMediaLink(Request $request, $id)
    {
        $socialMediaLink = SocialMediaLink::findOrFail($id);
        
        // Detach from all contact us records
        $socialMediaLink->contactUs()->detach();
        
        // Delete the social media link (this will also delete associated media)
        $socialMediaLink->delete();

        return response()->json(['success' => true]);
    }
}
