@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
    <a href="{{ route('admin.gallery.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-navy">Editar Item da Galeria</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $item->title }}</p>
    </div>
</div>

@if($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.gallery.update', $item) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
            <input type="text" name="description" value="{{ old('description', $item->description) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagem Actual</label>
            @if($item->image)
                <div class="mb-2">
                    <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset($item->image) }}" alt="{{ $item->title }}" class="h-40 rounded-lg object-cover border">
                </div>
            @endif
            <label class="block text-sm font-medium text-gray-700 mb-1">Nova Imagem (deixe vazio para manter)</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-yellow-600">
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Guardar Alterações</button>
        <a href="{{ route('admin.gallery.index') }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
    </div>
</form>
@endsection
