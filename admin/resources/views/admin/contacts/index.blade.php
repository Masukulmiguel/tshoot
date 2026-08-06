@extends('layouts.admin')
@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Contactos</h1>
        <p class="text-sm text-gray-500 mt-0.5">Gerir todos os contactos recebidos</p>
    </div>
    <a href="{{ route('admin.contacts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-navy bg-gold rounded-xl hover:bg-gold-light transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Novo Contacto
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <div class="p-4 border-b border-gray-100">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.contacts.index') }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ !request('status') ? 'bg-navy text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                Todos <span class="ml-1 opacity-70">({{ $counts['all'] }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'new']) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'new' ? 'bg-blue-500 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                Novos <span class="ml-1 opacity-70">({{ $counts['new'] }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'read' ? 'bg-amber-500 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                Lidos <span class="ml-1 opacity-70">({{ $counts['read'] }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'replied' ? 'bg-emerald-500 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                Respondidos <span class="ml-1 opacity-70">({{ $counts['replied'] }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'archived']) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'archived' ? 'bg-gray-500 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100' }}">
                Arquivados <span class="ml-1 opacity-70">({{ $counts['archived'] }})</span>
            </a>
        </div>
    </div>

    <div class="p-4">
        <form method="GET" action="{{ route('admin.contacts.index') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, email, assunto..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors">
            </div>
        </form>
    </div>
</div>

{{-- Contacts Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Contacto</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Assunto</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Data</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-gray-600">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $contact->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $contact->email }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="px-5 py-4 hidden sm:table-cell">
                            <p class="text-gray-600 truncate max-w-[200px]">{{ Str::limit($contact->subject ?? 'Sem assunto', 35) }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @if($contact->status === 'new')
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold rounded-full bg-blue-50 text-blue-600">Novo</span>
                            @elseif($contact->status === 'read')
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold rounded-full bg-amber-50 text-amber-600">Lido</span>
                            @elseif($contact->status === 'replied')
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold rounded-full bg-emerald-50 text-emerald-600">Respondido</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold rounded-full bg-gray-100 text-gray-500">Arquivado</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="text-xs text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.contacts.edit', $contact) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este contacto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Nenhum contacto encontrado</p>
                            <p class="text-xs text-gray-400 mt-1">Tente alterar os filtros ou crie um novo contacto</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection