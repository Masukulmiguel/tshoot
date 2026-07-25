@extends('layouts.admin')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Voltar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-start justify-between mb-6">
                <h1 class="text-xl font-bold text-gray-800">{{ $contact->subject }}</h1>
                <div>
                    @if($contact->status === 'new')
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Novo</span>
                    @elseif($contact->status === 'read')
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Lido</span>
                    @elseif($contact->status === 'replied')
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">Respondido</span>
                    @else
                        <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">Arquivado</span>
                    @endif
                </div>
            </div>

            <div class="prose max-w-none text-gray-700 mb-6">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>

        @if($contact->status !== 'archived')
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Responder</h2>
                <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                    @csrf
                    <textarea name="reply" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 mb-4" placeholder="Escreva a sua resposta..." required>{{ old('reply') }}</textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 text-white text-sm font-medium rounded-lg transition hover:opacity-90" style="background-color: #D4A11D;">
                            Enviar Resposta
                        </button>
                    </div>
                </form>
            </div>
        @endif

        @if(isset($contact->adminReply))
            <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4" style="border-left-color: #D4A11D;">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Resposta do Admin</h2>
                <p class="text-gray-500 text-sm mb-3">{{ $contact->adminReply->created_at->format('d/m/Y H:i') }}</p>
                <div class="text-gray-700">
                    {!! nl2br(e($contact->adminReply->message)) !!}
                </div>
            </div>
        @endif
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informações</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Nome</label>
                    <p class="text-gray-800 font-medium">{{ $contact->name }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Email</label>
                    <p class="text-gray-800 font-medium">{{ $contact->email }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Telefone</label>
                    <p class="text-gray-800 font-medium">{{ $contact->phone ?? 'Não fornecido' }}</p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Data</label>
                    <p class="text-gray-800 font-medium">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Alterar Estado</h2>
            <div class="flex flex-col gap-2">
                @if($contact->status !== 'read')
                    <form action="{{ route('admin.contacts.status', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="read">
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-yellow-300 text-yellow-700 hover:bg-yellow-50 transition">
                            Marcar como Lido
                        </button>
                    </form>
                @endif

                @if($contact->status !== 'replied')
                    <form action="{{ route('admin.contacts.status', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="replied">
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-green-300 text-green-700 hover:bg-green-50 transition">
                            Marcar como Respondido
                        </button>
                    </form>
                @endif

                @if($contact->status !== 'archived')
                    <form action="{{ route('admin.contacts.status', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="archived">
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                            Arquivar
                        </button>
                    </form>
                @endif

                @if($contact->status !== 'new')
                    <form action="{{ route('admin.contacts.status', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="new">
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-blue-300 text-blue-700 hover:bg-blue-50 transition">
                            Marcar como Novo
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
