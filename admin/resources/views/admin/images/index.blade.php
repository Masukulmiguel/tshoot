@extends('layouts.admin')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-navy">Imagens do Site</h1>
            <p class="text-sm text-gray-500 mt-1">Gerir as imagens das secções do site principal</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.images.create', ['category' => 'about']) }}" class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm font-medium">+ Nova Imagem</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    @php
        $categoryLabels = [
            'about' => 'Sobre Nós',
            'cards' => 'Como Trabalhamos',
            'gallery' => 'Assistência Técnica',
            'partners' => 'Parceiros / Carousel',
            'contact' => 'Contacto',
            'hero' => 'Hero / Banners',
            'infrastructure' => 'Infraestrutura',
        ];
        $categoryIcons = [
            'about' => 'fa-info-circle',
            'cards' => 'fa-handshake',
            'gallery' => 'fa-tools',
            'partners' => 'fa-handshake',
            'contact' => 'fa-envelope',
            'hero' => 'fa-panorama',
            'infrastructure' => 'fa-network-wired',
        ];
        $categoryColors = [
            'about' => 'blue',
            'cards' => 'purple',
            'gallery' => 'orange',
            'partners' => 'green',
            'contact' => 'red',
            'hero' => 'indigo',
            'infrastructure' => 'gray',
        ];
    @endphp

    @forelse($categoryLabels as $catKey => $catLabel)
        @if(isset($grouped[$catKey]) && count($grouped[$catKey]) > 0)
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-{{ $categoryColors[$catKey] ?? 'gray' }}-100 flex items-center justify-center">
                        <i class="fas {{ $categoryIcons[$catKey] ?? 'fa-image' }} text-{{ $categoryColors[$catKey] ?? 'gray' }}-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-navy">{{ $catLabel }}</h2>
                        <p class="text-xs text-gray-400">{{ count($grouped[$catKey]) }} imagem(ns)</p>
                    </div>
                    <a href="{{ route('admin.images.create', ['category' => $catKey]) }}" class="ml-auto text-xs bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition">+ Adicionar</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($grouped[$catKey] as $image)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden relative">
                                <img src="{{ asset($image->path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover">
                                @if($image->key)
                                    <span class="absolute top-2 left-2 text-[10px] px-2 py-0.5 rounded-full bg-navy/80 text-white font-medium">{{ $image->key }}</span>
                                @endif
                                @if(!$image->is_active)
                                    <span class="absolute top-2 right-2 text-[10px] px-2 py-0.5 rounded-full bg-red-500 text-white font-medium">Inativo</span>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $image->title ?? 'Sem título' }}</p>
                                @if($image->key)
                                    <p class="text-xs text-gray-400 mt-0.5">Slot: {{ $image->key }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-0.5">Ordem: {{ $image->sort_order }}</p>
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('admin.images.edit', $image) }}" class="flex-1 text-center text-xs bg-gray-100 text-gray-600 py-1.5 rounded-lg hover:bg-gray-200 transition">Editar</a>
                                    <form action="{{ route('admin.images.destroy', $image) }}" method="POST" onsubmit="return confirm('Eliminar esta imagem?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">Apagar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-images text-4xl mb-4"></i>
            <p>Nenhuma imagem carregada.</p>
            <a href="{{ route('admin.images.create') }}" class="mt-4 inline-block bg-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm">+ Carregar Primeira Imagem</a>
        </div>
    @endforelse
</div>
@endsection
