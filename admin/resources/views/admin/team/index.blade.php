@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Equipa</h1>
        <p class="text-sm text-gray-500 mt-1">Gerir os membros da equipa</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Novo Membro
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($members as $member)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-4">
                <div class="flex items-center gap-3 mb-3">
                    @if($member->photo)
                        <img src="{{ asset('uploads/' . $member->photo) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-gold font-bold text-lg">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h3 class="font-semibold text-navy text-sm truncate">{{ $member->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">{{ $member->role }}</p>
                    </div>
                </div>
                @if($member->bio)
                    <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ Str::limit($member->bio, 80) }}</p>
                @endif
                <div class="flex items-center justify-between">
                    @if($member->is_active)
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-50 text-green-600">Activo</span>
                    @else
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500">Inactivo</span>
                    @endif
                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.team.edit', $member) }}" class="p-1.5 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('Eliminar este membro?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-gray-400 text-center">Nenhum membro da equipa criado.</div>
    @endforelse
</div>
@endsection
