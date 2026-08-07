@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
    <a href="{{ route('admin.social-links.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-navy">Editar Rede Social</h1>
        <p class="text-sm text-gray-500 mt-1">Actualizar {{ $link->platform }}</p>
    </div>
</div>

@if($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.social-links.update', $link) }}" class="space-y-6">
    @csrf @method('PUT')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Plataforma *</label>
            <select name="platform" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                <option value="">Selecione...</option>
                <option value="facebook" {{ $link->platform === 'facebook' ? 'selected' : '' }}>Facebook</option>
                <option value="instagram" {{ $link->platform === 'instagram' ? 'selected' : '' }}>Instagram</option>
                <option value="whatsapp" {{ $link->platform === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="linkedin" {{ $link->platform === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                <option value="youtube" {{ $link->platform === 'youtube' ? 'selected' : '' }}>YouTube</option>
                <option value="tiktok" {{ $link->platform === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                <option value="twitter" {{ $link->platform === 'twitter' ? 'selected' : '' }}>Twitter / X</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
            <input type="url" name="url" value="{{ $link->url }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://facebook.com/...">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ícone (Font Awesome)</label>
            <input type="text" name="icon" value="{{ $link->icon }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="fab fa-facebook-f">
            <p class="text-xs text-gray-400 mt-1">Ex: fab fa-facebook-f, fab fa-instagram, fab fa-whatsapp</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Actualizar</button>
        <a href="{{ route('admin.social-links.index') }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">Cancelar</a>
    </div>
</form>
@endsection
