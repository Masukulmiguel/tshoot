<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:255',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['image'] = $filename;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = $validated['published_at'] ?? now();

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Publicação criada com sucesso!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:255',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                $oldPath = public_path('uploads/' . $post->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                    $dir = dirname($oldPath);
                    if (is_dir($dir) && count(scandir($dir)) <= 2) {
                        rmdir($dir);
                    }
                }
            }
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validated['image'] = $filename;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Publicação actualizada!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            $path = public_path('uploads/' . $post->image);
            if (file_exists($path)) {
                unlink($path);
                $dir = dirname($path);
                if (is_dir($dir) && count(scandir($dir)) <= 2) {
                    rmdir($dir);
                }
            }
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Publicação eliminada!');
    }
}
