<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\SiteContent;
use App\Models\SiteImage;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ContentApiController extends Controller
{
    public function getAll()
    {
        if (Banner::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'DefaultContentSeeder', '--force' => true]);
        }

        $banners = Banner::where('active', true)->orderBy('order')->get();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $contents = SiteContent::all()->groupBy('section');
        $images = SiteImage::where('is_active', true)->orderBy('sort_order')->get();
        $imagesByKey = $images->pluck('path', 'key')->toArray();
        $team = TeamMember::where('is_active', true)->orderBy('sort_order')->get();
        $posts = Post::where('is_published', true)->latest()->limit(6)->get();

        $allSettings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $publicKeys = [
            'company_name', 'company_slogan', 'website', 'logo',
            'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'og_image',
            'about_image', 'contact_bg',
        ];
        $settings = array_intersect_key($allSettings, array_flip($publicKeys));

        return response()->json([
            'banners' => $banners,
            'services' => $services,
            'contents' => $contents,
            'settings' => $settings,
            'images' => $images,
            'imagesByKey' => $imagesByKey,
            'team' => $team,
            'posts' => $posts,
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
          ->header('Access-Control-Allow-Headers', 'Content-Type');
    }
}
