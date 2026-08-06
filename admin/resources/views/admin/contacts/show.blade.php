@extends('layouts.admin')
@section('content')

<div class="max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-gray-900">{{ $contact->subject ?: 'Contacto de ' . $contact->name }}</h1>
                @if($contact->status === 'new')
                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-blue-50 text-blue-600">Novo</span>
                @elseif($contact->status === 'read')
                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-amber-50 text-amber-600">Lido</span>
                @elseif($contact->status === 'replied')
                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-emerald-50 text-emerald-600">Respondido</span>
                @else
                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-gray-100 text-gray-500">Arquivado</span>
                @endif
            </div>
            <p class="text-sm text-gray-500 mt-0.5">{{ $contact->name }} · {{ $contact->email }}</p>
        </div>
        <a href="{{ route('admin.contacts.edit', $contact) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-navy bg-gold rounded-xl hover:bg-gold-light transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/>
            </svg>
            Editar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Message --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Mensagem</h2>
                </div>
                <div class="p-6">
                    <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
                </div>
            </div>

            {{-- Reply Form --}}
            @if($contact->status !== 'archived')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Responder</h2>
                        <p class="text-xs text-gray-500 mt-0.5">A resposta será enviada por email para {{ $contact->email }}</p>
                    </div>
                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <textarea name="admin_reply" rows="4" required
                                      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors resize-none"
                                      placeholder="Escreva a sua resposta...">{{ old('admin_reply', $contact->admin_reply) }}</textarea>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-navy bg-gold rounded-xl hover:bg-gold-light transition-colors shadow-sm">
                                Enviar Resposta
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Admin Reply --}}
            @if($contact->admin_reply)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden border-l-4 border-l-gold">
                    <div class="px-6 py-4 border-b border-gray-100 bg-amber-50/30">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-gray-900">Resposta Enviada</h2>
                        </div>
                        @if($contact->replied_at)
                            <p class="text-xs text-gray-500 mt-0.5">{{ $contact->replied_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->admin_reply }}</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Informações</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Nome</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $contact->name }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Email</p>
                        <a href="mailto:{{ $contact->email }}" class="text-sm font-semibold text-gold hover:underline">{{ $contact->email }}</a>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Telefone</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $contact->phone ?: 'Não fornecido' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Data</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Alterar Estado</h2>
                </div>
                <div class="p-4 space-y-2">
                    @if($contact->status !== 'read')
                        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="read">
                            <button type="submit" class="w-full px-4 py-2.5 text-xs font-semibold rounded-xl border border-amber-200 text-amber-700 hover:bg-amber-50 transition-colors text-left flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                                Marcar como Lido
                            </button>
                        </form>
                    @endif
                    @if($contact->status !== 'replied')
                        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="replied">
                            <button type="submit" class="w-full px-4 py-2.5 text-xs font-semibold rounded-xl border border-emerald-200 text-emerald-700 hover:bg-emerald-50 transition-colors text-left flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Marcar como Respondido
                            </button>
                        </form>
                    @endif
                    @if($contact->status !== 'archived')
                        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="archived">
                            <button type="submit" class="w-full px-4 py-2.5 text-xs font-semibold rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-left flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                Arquivar
                            </button>
                        </form>
                    @endif
                    @if($contact->status !== 'new')
                        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="new">
                            <button type="submit" class="w-full px-4 py-2.5 text-xs font-semibold rounded-xl border border-blue-200 text-blue-700 hover:bg-blue-50 transition-colors text-left flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Marcar como Novo
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                <div class="p-4">
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este contacto permanentemente?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 text-xs font-semibold rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            Eliminar Contacto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection