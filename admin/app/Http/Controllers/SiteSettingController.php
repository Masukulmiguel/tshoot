<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    private array $allowedSettings = [
        'general' => ['company_name', 'company_slogan', 'email', 'phone', 'address', 'website', 'logo', 'about_image', 'contact_bg'],
        'seo' => ['meta_title', 'meta_description', 'meta_keywords', 'og_title', 'og_description', 'og_image', 'google_analytics'],
    ];

    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, CloudinaryService $cloudinary)
    {
        $data = $request->except(['_token', '_method']);
        $allAllowed = array_merge(...array_values($this->allowedSettings));

        foreach ($data as $key => $value) {
            if (!in_array($key, $allAllowed)) {
                continue;
            }

            $group = str_starts_with($key, 'meta_') || str_starts_with($key, 'og_') || $key === 'google_analytics'
                ? 'seo'
                : 'general';

            $validated = match ($key) {
                'email' => filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null,
                'phone' => preg_match('/^[\d\s\-\+\(\)]{7,20}$/', $value) ? $value : null,
                'meta_title', 'og_title' => mb_substr($value, 0, 255),
                'meta_description', 'og_description' => mb_substr($value, 0, 500),
                'meta_keywords' => mb_substr($value, 0, 500),
                'og_image' => filter_var($value, FILTER_VALIDATE_URL) ? $value : null,
                default => $value,
            };

            if ($validated !== null) {
                SiteSetting::set($key, $validated, $group);
            }
        }

        $imageFields = ['about_image', 'contact_bg'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($cloudinary->isConfigured()) {
                    $oldValue = SiteSetting::get($field);
                    if ($oldValue && str_contains($oldValue, 'cloudinary.com')) {
                        preg_match('/\/upload\/(?:v\d+\/)?(.+?)\.\w+$/', $oldValue, $m);
                        if (!empty($m[1])) {
                            $cloudinary->delete($m[1]);
                        }
                    }
                    $url = $cloudinary->upload($request->file($field), 'tshoot/settings');
                    SiteSetting::set($field, $url, 'general');
                } else {
                    $file = $request->file($field);
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $filename);
                    SiteSetting::set($field, 'uploads/' . $filename, 'general');
                }
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Configurações actualizadas!');
    }
}
