<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request, SupabaseService $supabase)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($supabase->isConfigured()) {
                $url = $supabase->upload($request->file('photo'), 'uploads', 'team');
                $validated['photo'] = $url;
            } else {
                $file = $request->file('photo');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['photo'] = $filename;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Membro da equipa criado com sucesso!');
    }

    public function edit(TeamMember $member)
    {
        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, TeamMember $member, SupabaseService $supabase)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($supabase->isConfigured()) {
                if (str_contains($member->photo ?? '', 'supabase')) {
                    $supabase->delete($member->photo);
                }
                $url = $supabase->upload($request->file('photo'), 'uploads', 'team');
                $validated['photo'] = $url;
            } else {
                if ($member->photo && !str_contains($member->photo, 'supabase')) {
                    $oldPath = public_path('uploads/' . $member->photo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $file = $request->file('photo');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['photo'] = $filename;
            }
        }

        $validated['is_active'] = $request->boolean('is_active');
        $member->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Membro da equipa actualizado!');
    }

    public function destroy(TeamMember $member, SupabaseService $supabase)
    {
        if (str_contains($member->photo ?? '', 'supabase')) {
            $supabase->delete($member->photo);
        } elseif ($member->photo) {
            $path = public_path('uploads/' . $member->photo);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $member->delete();
        return redirect()->route('admin.team.index')->with('success', 'Membro da equipa eliminado!');
    }
}
