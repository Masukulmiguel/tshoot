@extends('layouts.admin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.posts.index') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy flex items-center gap-2">
                <i class="fas fa-pen-to-square text-gold"></i> Nova Publicação
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Criar uma nova publicação no blog</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-heading text-gold mr-1"></i> Título *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition" placeholder="Título da publicação">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-align-left text-gold mr-1"></i> Resumo</label>
            <textarea name="excerpt" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y transition" placeholder="Breve descrição da publicação...">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-file-alt text-gold mr-1"></i> Conteúdo</label>
            <textarea name="content" rows="10" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y transition" placeholder="Escreva o conteúdo completo da publicação...">{{ old('content') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-folder text-gold mr-1"></i> Categoria</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
                    <option value="noticias" {{ old('category') == 'noticias' ? 'selected' : '' }}>Notícias</option>
                    <option value="dicas" {{ old('category') == 'dicas' ? 'selected' : '' }}>Dicas</option>
                    <option value="tutoriais" {{ old('category') == 'tutoriais' ? 'selected' : '' }}>Tutoriais</option>
                    <option value="eventos" {{ old('category') == 'eventos' ? 'selected' : '' }}>Eventos</option>
                    <option value="empresa" {{ old('category') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user-edit text-gold mr-1"></i> Autor</label>
                <input type="text" name="author" value="{{ old('author') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition" placeholder="Nome do autor">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-image text-gold mr-1"></i> Imagem</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-gold/10 file:text-gold file:font-semibold file:text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-calendar text-gold mr-1"></i> Data de Publicação</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
        </div>

        <div class="flex items-center gap-6 mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', 0) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                <span class="text-sm text-gray-700 font-medium"><i class="fas fa-globe text-green-500 mr-1"></i> Publicado</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', 0) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                <span class="text-sm text-gray-700 font-medium"><i class="fas fa-star text-gold mr-1"></i> Destacado</span>
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="px-6 py-2.5 bg-gold text-white text-sm font-semibold rounded-lg hover:bg-gold/90 transition-colors shadow-sm">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
            <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
