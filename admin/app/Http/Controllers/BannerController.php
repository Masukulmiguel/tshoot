<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request, CloudinaryService $cloudinary)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order' => 'nullable|integer',
            'active' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            if ($cloudinary->isConfigured()) {
                $url = $cloudinary->upload($request->file('image'), 'tshoot/banners');
                $validated['image'] = $url;
            } else {
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
        }

        $validated['active'] = $request->boolean('active');
        $validated['order'] = $validated['order'] ?? 0;

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner criado com sucesso!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner, CloudinaryService $cloudinary)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order' => 'nullable|integer',
            'active' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            if ($cloudinary->isConfigured()) {
                $this->deleteFromCloudinary($banner->image, $cloudinary);
                $url = $cloudinary->upload($request->file('image'), 'tshoot/banners');
                $validated['image'] = $url;
            } else {
                if ($banner->image && !str_contains($banner->image, 'cloudinary.com')) {
                    $oldPath = public_path('uploads/' . $banner->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
        }

        $validated['active'] = $request->boolean('active');

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner actualizado!');
    }

    public function destroy(Banner $banner, CloudinaryService $cloudinary)
    {
        $this->deleteFromCloudinary($banner->image, $cloudinary);

        if ($banner->image && !str_contains($banner->image, 'cloudinary.com')) {
            $path = public_path('uploads/' . $banner->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner eliminado!');
    }

    private function deleteFromCloudinary(?string $image, CloudinaryService $cloudinary): void
    {
        if ($image && str_contains($image, 'cloudinary.com')) {
            preg_match('/\/upload\/(?:v\d+\/)?(.+?)\.\w+$/', $image, $matches);
            if (!empty($matches[1])) {
                $cloudinary->delete($matches[1]);
            }
        }
    }
}
