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
            'phone', 'whatsapp', 'email', 'address',
            'hours_weekday', 'hours_saturday', 'hours_sunday',
            'facebook', 'instagram', 'linkedin', 'youtube',
            'contact_title', 'contact_subtitle',
        ];
        $settings = array_intersect_key($allSettings, array_flip($publicKeys));

        $adminUrl = config('app.url', 'https://tshoot-admin-6t0l.onrender.com');

        return response()->json([
            'banners' => $banners->map(function ($banner) use ($adminUrl) {
                $banner->image_url = $this->resolveUrl($banner->image, $adminUrl);
                return $banner;
            }),
            'services' => $services,
            'contents' => $contents,
            'settings' => collect($settings)->mapWithKeys(function ($value, $key) use ($adminUrl) {
                $resolved = in_array($key, ['about_image', 'contact_bg', 'logo'])
                    ? $this->resolveUrl($value, $adminUrl)
                    : $value;
                return [$key => $resolved];
            })->toArray(),
            'images' => $images->map(function ($image) use ($adminUrl) {
                $image->url = $this->resolveUrl($image->path, $adminUrl);
                return $image;
            }),
            'imagesByKey' => collect($imagesByKey)->mapWithKeys(function ($path, $key) use ($adminUrl) {
                return [$key => $this->resolveUrl($path, $adminUrl)];
            })->toArray(),
            'team' => $team->map(function ($member) use ($adminUrl) {
                $member->photo_url = $this->resolveUrl($member->photo, $adminUrl);
                return $member;
            }),
            'posts' => $posts->map(function ($post) use ($adminUrl) {
                $post->image_url = $this->resolveUrl($post->image, $adminUrl);
                return $post;
            }),
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
          ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    private function resolveUrl(?string $path, string $adminUrl): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return rtrim($adminUrl, '/') . '/' . ltrim($path, '/');
    }
}
