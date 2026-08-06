<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CloudinaryService;
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

    public function store(Request $request, CloudinaryService $cloudinary)
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
            if ($cloudinary->isConfigured()) {
                $url = $cloudinary->upload($request->file('image'), 'tshoot/posts');
                $validated['image'] = $url;
            } else {
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
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

    public function update(Request $request, Post $post, CloudinaryService $cloudinary)
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
            if ($cloudinary->isConfigured()) {
                if ($post->image && str_contains($post->image, 'cloudinary.com')) {
                    preg_match('/\/upload\/(?:v\d+\/)?(.+?)\.\w+$/', $post->image, $m);
                    if (!empty($m[1])) {
                        $cloudinary->delete($m[1]);
                    }
                }
                $url = $cloudinary->upload($request->file('image'), 'tshoot/posts');
                $validated['image'] = $url;
            } else {
                if ($post->image && !str_contains($post->image, 'cloudinary.com')) {
                    $oldPath = public_path('uploads/' . $post->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $validated['image'] = $filename;
            }
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured'] = $request->boolean('is_featured');

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Publicação actualizada!');
    }

    public function destroy(Post $post, CloudinaryService $cloudinary)
    {
        if ($post->image && str_contains($post->image, 'cloudinary.com')) {
            preg_match('/\/upload\/(?:v\d+\/)?(.+?)\.\w+$/', $post->image, $m);
            if (!empty($m[1])) {
                $cloudinary->delete($m[1]);
            }
        } elseif ($post->image) {
            $path = public_path('uploads/' . $post->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Publicação eliminada!');
    }
}
