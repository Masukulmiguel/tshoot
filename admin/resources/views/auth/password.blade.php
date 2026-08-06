@extends('layouts.admin')
@section('content')

<div class="max-w-lg mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy flex items-center gap-2">
                <i class="fas fa-lock text-gold"></i> Alterar Senha
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Actualize a sua senha de acesso</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.password.update') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-key text-gold mr-1"></i> Senha Actual *</label>
            <input type="password" name="current_password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            @error('current_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-lock text-gold mr-1"></i> Nova Senha *</label>
            <input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1"><i class="fas fa-check-circle text-gold mr-1"></i> Confirmar Nova Senha *</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="px-6 py-2.5 bg-gold text-white text-sm font-semibold rounded-lg hover:bg-gold/90 transition-colors shadow-sm">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
