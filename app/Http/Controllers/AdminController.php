<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Link;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get counts for dashboard widgets
        $counts = [
            'banners' => Banner::count(),
            'faqs' => Faq::count(),
            'services' => Service::count(),
            'testimonials' => Testimonial::count(),
            'partners' => Partner::count(),
            'links' => Link::count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
