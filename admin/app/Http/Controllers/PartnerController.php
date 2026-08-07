<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request, SupabaseService $supabase)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website' => 'nullable|url|max:500',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            if ($supabase->isConfigured()) {
                $logoPath = $supabase->upload($request->file('logo'), 'uploads', 'partners');
            } else {
                $file = $request->file('logo');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/partners'), $filename);
                $logoPath = 'uploads/partners/' . $filename;
            }
        }

        Partner::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'website' => $request->website,
            'sort_order' => Partner::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Parceiro criado com sucesso!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner, SupabaseService $supabase)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('logo')) {
            if ($supabase->isConfigured()) {
                if (str_contains($partner->logo ?? '', 'supabase')) {
                    $supabase->delete($partner->logo);
                }
                $partner->logo = $supabase->upload($request->file('logo'), 'uploads', 'partners');
            } else {
                if ($partner->logo && !str_contains($partner->logo, 'supabase')) {
                    $oldPath = public_path($partner->logo);
                    if (file_exists($oldPath)) unlink($oldPath);
                }
                $file = $request->file('logo');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/partners'), $filename);
                $partner->logo = 'uploads/partners/' . $filename;
            }
        }

        $partner->name = $request->name;
        $partner->website = $request->website;
        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Parceiro actualizado com sucesso!');
    }

    public function destroy(Partner $partner, SupabaseService $supabase)
    {
        if (str_contains($partner->logo ?? '', 'supabase')) {
            $supabase->delete($partner->logo);
        } elseif ($partner->logo) {
            $filePath = public_path($partner->logo);
            if (file_exists($filePath)) unlink($filePath);
        }

        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Parceiro eliminado.');
    }

    public function toggle(Partner $partner)
    {
        $partner->is_active = !$partner->is_active;
        $partner->save();
        return response()->json(['success' => true, 'is_active' => $partner->is_active]);
    }
}
