@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy flex items-center gap-2">
            <i class="fas fa-newspaper text-gold"></i> Blog
        </h1>
        <p class="text-sm text-gray-500 mt-1">Gerir as publicações do site</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold text-white text-sm font-semibold rounded-lg hover:bg-gold/90 transition-colors shadow-sm">
        <i class="fas fa-plus"></i> Nova Publicação
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-navy/10 flex items-center justify-center">
            <i class="fas fa-newspaper text-navy text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $posts->count() }}</p>
            <p class="text-xs text-gray-500">Total</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $posts->where('is_published', true)->count() }}</p>
            <p class="text-xs text-gray-500">Publicados</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
            <i class="fas fa-file-alt text-gray-400 text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $posts->where('is_published', false)->count() }}</p>
            <p class="text-xs text-gray-500">Rascunhos</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gold/10 flex items-center justify-center">
            <i class="fas fa-star text-gold text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $posts->where('is_featured', true)->count() }}</p>
            <p class="text-xs text-gray-500">Destacados</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-100 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Imagem</th>
                    <th class="px-5 py-3 font-medium">Título</th>
                    <th class="px-5 py-3 font-medium">Categoria</th>
                    <th class="px-5 py-3 font-medium">Autor</th>
                    <th class="px-5 py-3 font-medium">Data</th>
                    <th class="px-5 py-3 font-medium">Estado</th>
                    <th class="px-5 py-3 font-medium text-right">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3">
                            @if($post->image)
                                <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('uploads/' . $post->image) }}" alt="" class="w-16 h-10 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-16 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-xs"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-navy">{{ Str::limit($post->title, 40) }}</span>
                                @if($post->is_featured)
                                    <span class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-gold/10 text-gold uppercase">Destacado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-navy/10 text-navy">{{ $post->category }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $post->author ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">
                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                            {{ $post->published_at?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="px-5 py-3">
                            @if($post->is_published)
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-600"><i class="fas fa-check-circle mr-1"></i>Publicado</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500"><i class="fas fa-edit mr-1"></i>Rascunho</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="p-2 text-gray-400 hover:text-gold hover:bg-gold/10 rounded-lg transition-colors" title="Editar">
                                    <i class="fas fa-pen text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Eliminar esta publicação?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-newspaper text-gray-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Nenhuma publicação criada.</p>
                            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 mt-3 text-gold hover:text-gold/80 text-sm font-semibold">
                                <i class="fas fa-plus"></i> Criar primeira publicação
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
