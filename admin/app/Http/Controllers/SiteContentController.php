<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
    private array $allowedFields = [
        'hero' => ['title', 'subtitle', 'description', 'button_text', 'button_link', 'video_url'],
        'about' => ['title', 'subtitle', 'description', 'mission', 'vision', 'values'],
        'services' => ['title', 'subtitle', 'description'],
        'team' => ['title', 'subtitle', 'description'],
        'contact' => ['title', 'subtitle', 'description', 'address', 'map_embed'],
        'footer' => ['description', 'copyright'],
        'cta' => ['title', 'subtitle', 'button_text', 'button_link'],
    ];

    public function index()
    {
        $sections = SiteContent::all()->groupBy('section');
        return view('admin.content.index', compact('sections'));
    }

    public function edit($section)
    {
        $contents = SiteContent::where('section', $section)->get();
        return view('admin.content.edit', compact('contents', 'section'));
    }

    public function update(Request $request, $section)
    {
        $allowed = $this->allowedFields[$section] ?? null;

        if (!$allowed) {
            return back()->withErrors(['section' => 'Secção inválida.']);
        }

        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                SiteContent::set($section, $key, $value);
            }
        }

        return redirect()->route('admin.content.edit', $section)->with('success', 'Conteúdo actualizado!');
    }
}
