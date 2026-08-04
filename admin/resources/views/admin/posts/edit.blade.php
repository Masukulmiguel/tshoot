@extends('layouts.admin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.posts.index') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-navy">Editar Publicação</h1>
    </div>

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Resumo</label>
            <textarea name="excerpt" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Conteúdo</label>
            <textarea name="content" rows="10" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                    <option value="noticias" {{ old('category', $post->category) == 'noticias' ? 'selected' : '' }}>Notícias</option>
                    <option value="dicas" {{ old('category', $post->category) == 'dicas' ? 'selected' : '' }}>Dicas</option>
                    <option value="tutoriais" {{ old('category', $post->category) == 'tutoriais' ? 'selected' : '' }}>Tutoriais</option>
                    <option value="eventos" {{ old('category', $post->category) == 'eventos' ? 'selected' : '' }}>Eventos</option>
                    <option value="empresa" {{ old('category', $post->category) == 'empresa' ? 'selected' : '' }}>Empresa</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Autor</label>
                <input type="text" name="author" value="{{ old('author', $post->author) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagem</label>
                @if($post->image)
                    <div class="mb-2">
                        <img src="{{ asset('uploads/' . $post->image) }}" alt="" class="w-32 h-20 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data de Publicação</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
            </div>
        </div>

        <div class="flex items-center gap-6 mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                <span class="text-sm text-gray-700">Publicado</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                <span class="text-sm text-gray-700">Destacado</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Actualizar</button>
            <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">Cancelar</a>
        </div>
    </form>
</div>
@endsection
