<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SocialLinkController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('social_links')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        }
        $links = SocialLink::orderBy('sort_order')->get();
        return view('admin.social-links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|string|max:100',
        ]);

        SocialLink::create([
            'platform' => $request->platform,
            'url' => $request->url,
            'icon' => $request->icon,
            'sort_order' => SocialLink::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.social-links.index')->with('success', 'Rede social criada com sucesso!');
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', ['link' => $socialLink]);
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:500',
            'icon' => 'nullable|string|max:100',
        ]);

        $socialLink->update([
            'platform' => $request->platform,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.social-links.index')->with('success', 'Rede social actualizada com sucesso!');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return redirect()->route('admin.social-links.index')->with('success', 'Rede social eliminada.');
    }

    public function toggle(SocialLink $socialLink)
    {
        $socialLink->is_active = !$socialLink->is_active;
        $socialLink->save();
        return response()->json(['success' => true, 'is_active' => $socialLink->is_active]);
    }
}
