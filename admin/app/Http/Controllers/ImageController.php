<?php

namespace App\Http\Controllers;

use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        $images = SiteImage::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.images.index', compact('images'));
    }

    public function create()
    {
        return view('admin.images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'required|in:hero,about,gallery,infrastructure,partners',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/images'), $filename);

        SiteImage::create([
            'filename' => $filename,
            'path' => 'uploads/images/' . $filename,
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => SiteImage::where('category', $request->category)->max('sort_order') + 1,
        ]);

        return redirect()->route('admin.images.index')
            ->with('success', 'Imagem carregada com sucesso!');
    }

    public function edit(SiteImage $image)
    {
        return view('admin.images.edit', compact('image'));
    }

    public function update(Request $request, SiteImage $image)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'required|in:hero,about,gallery,infrastructure,partners',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $oldPath = public_path($image->path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/images'), $filename);

            $image->filename = $filename;
            $image->path = 'uploads/images/' . $filename;
        }

        $image->category = $request->category;
        $image->title = $request->title;
        $image->description = $request->description;
        $image->sort_order = $request->sort_order ?? $image->sort_order;
        $image->is_active = $request->boolean('is_active', true);
        $image->save();

        return redirect()->route('admin.images.index')
            ->with('success', 'Imagem actualizada com sucesso!');
    }

    public function destroy(SiteImage $image)
    {
        $filePath = public_path($image->path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $image->delete();

        return redirect()->route('admin.images.index')
            ->with('success', 'Imagem eliminada.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        foreach ($request->ids as $index => $id) {
            SiteImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
