@extends('layouts.admin')
@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-navy">Gestão de Imagens</h1>
        <a href="{{ route('admin.images.create') }}" class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm font-medium">+ Nova Imagem</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($images as $image)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset($image->path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ ucfirst($image->category) }}</span>
                        <span class="text-xs {{ $image->is_active ? 'text-green-600' : 'text-red-500' }}">{{ $image->is_active ? 'Ativo' : 'Inativo' }}</span>
                    </div>
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $image->title ?? 'Sem título' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Ordem: {{ $image->sort_order }}</p>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('admin.images.edit', $image) }}" class="flex-1 text-center text-xs bg-gray-100 text-gray-600 py-1.5 rounded-lg hover:bg-gray-200 transition">Editar</a>
                        <form action="{{ route('admin.images.destroy', $image) }}" method="POST" onsubmit="return confirm('Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">Apagar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400">Nenhuma imagem.</div>
        @endforelse
    </div>
</div>
@endsection
