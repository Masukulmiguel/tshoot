@extends('layouts.admin')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.services.index') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-navy">Editar Serviço</h1>
    </div>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Descrição Curta</label>
            <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}" maxlength="255" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Descrição Completa</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ícone (Font Awesome)</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="fas fa-laptop">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select name="category" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                    <option value="general" {{ old('category', $service->category) == 'general' ? 'selected' : '' }}>Geral</option>
                    <option value="hardware" {{ old('category', $service->category) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="software" {{ old('category', $service->category) == 'software' ? 'selected' : '' }}>Software</option>
                    <option value="network" {{ old('category', $service->category) == 'network' ? 'selected' : '' }}>Redes</option>
                    <option value="security" {{ old('category', $service->category) == 'security' ? 'selected' : '' }}>Segurança</option>
                    <option value="cloud" {{ old('category', $service->category) == 'cloud' ? 'selected' : '' }}>Cloud</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Imagem</label>
            @if($service->image)
                <div class="mb-2">
                    <img src="{{ asset('uploads/' . $service->image) }}" alt="" class="w-32 h-20 object-cover rounded-lg">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordem</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                    <span class="text-sm text-gray-700">Activo</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Actualizar</button>
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">Cancelar</a>
        </div>
    </form>
</div>
@endsection
