<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\SiteContent;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContentApiController extends Controller
{
    public function getAll()
    {
        $banners = Banner::where('active', true)->orderBy('order')->get();
        $contents = SiteContent::all()->groupBy('section');
        $settings = SiteSetting::all()->pluck('value', 'key');
        $images = SiteImage::where('active', true)->orderBy('order')->get();

        return response()->json([
            'banners' => $banners,
            'contents' => $contents,
            'settings' => $settings,
            'images' => $images,
        ]);
    }
}
