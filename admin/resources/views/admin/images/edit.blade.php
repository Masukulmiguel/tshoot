@extends('layouts.admin')
@section('content')
<div class="p-6 max-w-xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.images.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-navy">Editar Imagem</h1>
    </div>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
            <img src="{{ asset($image->path) }}" alt="{{ $image->title }}" class="max-h-48 object-contain">
        </div>
        <form action="{{ route('admin.images.update', $image) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria *</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @php
                        $categories = [
                            'about' => 'Sobre Nós',
                            'cards' => 'Como Trabalhamos',
                            'gallery' => 'Assistência Técnica',
                            'partners' => 'Parceiros / Carousel',
                            'contact' => 'Contacto',
                            'hero' => 'Hero / Banners',
                            'infrastructure' => 'Infraestrutura',
                        ];
                    @endphp
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ $image->category === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Slot (Posição)</label>
                <select name="key" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Sem slot específico</option>
                    @foreach($availableSlots as $slotKey => $slotLabel)
                        @if($image->key === $slotKey || !in_array($slotKey, $existingKeys))
                            <option value="{{ $slotKey }}" {{ $image->key === $slotKey ? 'selected' : '' }}>{{ $slotLabel }}</option>
                        @endif
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Define onde a imagem aparece no site</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nova Imagem (opcional)</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-yellow-600">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" value="{{ $image->title }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $image->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordem</label>
                <input type="number" name="sort_order" value="{{ $image->sort_order }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ $image->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-gold">
                <label class="text-sm text-gray-700">Ativo</label>
            </div>
            <button type="submit" class="w-full bg-gold text-white py-2.5 rounded-lg font-medium hover:bg-yellow-600 transition">Guardar</button>
        </form>
    </div>
</div>
@endsection
