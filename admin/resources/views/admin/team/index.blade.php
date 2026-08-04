@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy flex items-center gap-2">
            <i class="fas fa-users text-gold"></i> Equipa
        </h1>
        <p class="text-sm text-gray-500 mt-1">Gerir os membros da equipa</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold text-white text-sm font-semibold rounded-lg hover:bg-gold/90 transition-colors shadow-sm">
        <i class="fas fa-plus"></i> Novo Membro
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-navy/10 flex items-center justify-center">
            <i class="fas fa-users text-navy text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $members->count() }}</p>
            <p class="text-xs text-gray-500">Total de Membros</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
            <i class="fas fa-user-check text-green-500 text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $members->where('is_active', true)->count() }}</p>
            <p class="text-xs text-gray-500">Activos</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
            <i class="fas fa-user-slash text-gray-400 text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-navy">{{ $members->where('is_active', false)->count() }}</p>
            <p class="text-xs text-gray-500">Inactivos</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($members as $member)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group">
            <div class="relative">
                @if($member->photo)
                    <img src="{{ asset('uploads/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-navy to-navy-light flex items-center justify-center">
                        <span class="text-gold font-bold text-4xl">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="absolute top-2 right-2">
                    @if($member->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white shadow"><i class="fas fa-check-circle"></i> Activo</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-400 text-white shadow"><i class="fas fa-times-circle"></i> Inactivo</span>
                    @endif
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-navy text-base">{{ $member->name }}</h3>
                <p class="text-gold text-xs font-semibold uppercase tracking-wide mt-0.5">{{ $member->role }}</p>
                @if($member->bio)
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ Str::limit($member->bio, 100) }}</p>
                @endif
                <div class="flex items-center gap-1 mt-3 pt-3 border-t border-gray-100">
                    @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="p-2 text-gray-400 hover:text-navy hover:bg-navy/5 rounded-lg transition-colors" title="Email">
                            <i class="fas fa-envelope text-sm"></i>
                        </a>
                    @endif
                    @if($member->phone)
                        <a href="tel:{{ $member->phone }}" class="p-2 text-gray-400 hover:text-navy hover:bg-navy/5 rounded-lg transition-colors" title="Telefone">
                            <i class="fas fa-phone text-sm"></i>
                        </a>
                    @endif
                    @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="LinkedIn">
                            <i class="fab fa-linkedin text-sm"></i>
                        </a>
                    @endif
                    @if($member->facebook)
                        <a href="{{ $member->facebook }}" target="_blank" class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Facebook">
                            <i class="fab fa-facebook text-sm"></i>
                        </a>
                    @endif
                    <div class="ml-auto flex items-center gap-1">
                        <a href="{{ route('admin.team.edit', $member) }}" class="p-2 text-gray-400 hover:text-gold hover:bg-gold/10 rounded-lg transition-colors" title="Editar">
                            <i class="fas fa-pen text-sm"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('Eliminar este membro da equipa?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-300 text-3xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Nenhum membro da equipa criado.</p>
            <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 mt-3 text-gold hover:text-gold/80 text-sm font-semibold">
                <i class="fas fa-plus"></i> Adicionar primeiro membro
            </a>
        </div>
    @endforelse
</div>
@endsection
