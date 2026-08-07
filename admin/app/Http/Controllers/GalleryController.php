<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\SiteSetting;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('sort_order')->get();
        $sectionTitle = SiteSetting::get('gallery_title') ?? 'Assistência Técnica';
        $sectionSubtitle = SiteSetting::get('gallery_subtitle') ?? 'Trabalhamos com os melhores equipamentos e tecnologias do mercado';
        return view('admin.gallery.index', compact('items', 'sectionTitle', 'sectionSubtitle'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request, SupabaseService $supabase)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($supabase->isConfigured()) {
            $url = $supabase->upload($request->file('image'), 'uploads', 'gallery');
            $path = $url;
        } else {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);
            $path = 'uploads/gallery/' . $filename;
        }

        GalleryItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'sort_order' => GalleryItem::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Item criado com sucesso!');
    }

    public function edit(GalleryItem $item)
    {
        return view('admin.gallery.edit', compact('item'));
    }

    public function update(Request $request, GalleryItem $item, SupabaseService $supabase)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($supabase->isConfigured()) {
                if (str_contains($item->image ?? '', 'supabase')) {
                    $supabase->delete($item->image);
                }
                $url = $supabase->upload($request->file('image'), 'uploads', 'gallery');
                $item->image = $url;
            } else {
                if ($item->image && !str_contains($item->image, 'supabase')) {
                    $oldPath = public_path($item->image);
                    if (file_exists($oldPath)) unlink($oldPath);
                }
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/gallery'), $filename);
                $item->image = 'uploads/gallery/' . $filename;
            }
        }

        $item->title = $request->title;
        $item->description = $request->description;
        $item->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Item actualizado com sucesso!');
    }

    public function destroy(GalleryItem $item, SupabaseService $supabase)
    {
        if (str_contains($item->image ?? '', 'supabase')) {
            $supabase->delete($item->image);
        } elseif ($item->image) {
            $filePath = public_path($item->image);
            if (file_exists($filePath)) unlink($filePath);
        }

        $item->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Item eliminado.');
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'gallery_title' => 'required|string|max:255',
            'gallery_subtitle' => 'nullable|string|max:500',
        ]);

        SiteSetting::set('gallery_title', $request->gallery_title, 'general');
        SiteSetting::set('gallery_subtitle', $request->gallery_subtitle, 'general');

        return redirect()->route('admin.gallery.index')->with('success', 'Secção actualizada!');
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $index => $id) {
            GalleryItem::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}
