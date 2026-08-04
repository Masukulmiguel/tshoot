<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
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

    public function store(Request $request)
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
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['photo'] = $filename;
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

    public function update(Request $request, TeamMember $member)
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
            if ($member->photo) {
                $oldPath = public_path('uploads/' . $member->photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                    $dir = dirname($oldPath);
                    if (is_dir($dir) && count(scandir($dir)) <= 2) {
                        rmdir($dir);
                    }
                }
            }
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['photo'] = $filename;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $member->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Membro da equipa actualizado!');
    }

    public function destroy(TeamMember $member)
    {
        if ($member->photo) {
            $path = public_path('uploads/' . $member->photo);
            if (file_exists($path)) {
                unlink($path);
                $dir = dirname($path);
                if (is_dir($dir) && count(scandir($dir)) <= 2) {
                    rmdir($dir);
                }
            }
        }
        $member->delete();
        return redirect()->route('admin.team.index')->with('success', 'Membro da equipa eliminado!');
    }
}
