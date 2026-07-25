<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;

class SiteContentController extends Controller
{
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
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            SiteContent::set($section, $key, $value);
        }

        return redirect()->route('admin.content.edit', $section)->with('success', 'Conteúdo actualizado!');
    }
}
