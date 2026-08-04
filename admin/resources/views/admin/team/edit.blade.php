@extends('layouts.admin')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.team.index') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy flex items-center gap-2">
                <i class="fas fa-user-edit text-gold"></i> Editar Membro da Equipa
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Actualizar os dados de {{ $member->name }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-user text-gold mr-1"></i> Nome *</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-briefcase text-gold mr-1"></i> Cargo *</label>
                <input type="text" name="role" value="{{ old('role', $member->role) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-align-left text-gold mr-1"></i> Biografia</label>
            <textarea name="bio" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y transition">{{ old('bio', $member->bio) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-camera text-gold mr-1"></i> Foto</label>
            @if($member->photo)
                <div class="mb-2 flex items-center gap-3">
                    <img src="{{ asset('uploads/' . $member->photo) }}" alt="" class="w-16 h-16 rounded-full object-cover shadow">
                    <span class="text-xs text-gray-400"><i class="fas fa-info-circle mr-1"></i> Nova imagem substitui a actual</span>
                </div>
            @endif
            <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-gold/10 file:text-gold file:font-semibold file:text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-envelope text-gold mr-1"></i> Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-phone text-gold mr-1"></i> Telefone</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fab fa-linkedin text-blue-600 mr-1"></i> LinkedIn</label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fab fa-facebook text-blue-500 mr-1"></i> Facebook</label>
                <input type="url" name="facebook" value="{{ old('facebook', $member->facebook) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fab fa-twitter text-sky-500 mr-1"></i> Twitter</label>
                <input type="url" name="twitter" value="{{ old('twitter', $member->twitter) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-sort-numeric-up text-gold mr-1"></i> Ordem</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="w-4 h-4 text-gold border-gray-300 rounded focus:ring-gold">
                    <span class="text-sm text-gray-700 font-medium"><i class="fas fa-check-circle text-green-500 mr-1"></i> Activo</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="px-6 py-2.5 bg-gold text-white text-sm font-semibold rounded-lg hover:bg-gold/90 transition-colors shadow-sm">
                <i class="fas fa-save mr-1"></i> Actualizar
            </button>
            <a href="{{ route('admin.team.index') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
