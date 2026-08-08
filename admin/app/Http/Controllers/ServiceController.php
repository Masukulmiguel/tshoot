<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request, SupabaseService $supabase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($supabase->isConfigured()) {
                $url = $supabase->upload($request->file('image'), 'uploads', 'services');
                $validated['image'] = $url;
            } else {
                @mkdir(public_path('uploads'), 0777, true);
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Serviço criado com sucesso!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service, SupabaseService $supabase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($supabase->isConfigured()) {
                if (str_contains($service->image ?? '', 'supabase')) {
                    $supabase->delete($service->image);
                }
                $url = $supabase->upload($request->file('image'), 'uploads', 'services');
                $validated['image'] = $url;
            } else {
                if ($service->image && !str_contains($service->image, 'supabase')) {
                    $oldPath = public_path('uploads/' . $service->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                @mkdir(public_path('uploads'), 0777, true);
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Serviço actualizado!');
    }

    public function destroy(Service $service, SupabaseService $supabase)
    {
        if (str_contains($service->image ?? '', 'supabase')) {
            $supabase->delete($service->image);
        } elseif ($service->image) {
            $path = public_path('uploads/' . $service->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Serviço eliminado!');
    }
}
