@extends('layouts.admin')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Contactos</h1>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-4 border-b">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ !request('status') ? 'text-white' : 'text-gray-600 hover:bg-gray-100' }}" style="{{ !request('status') ? 'background-color: #1B2A41;' : '' }}">
                Todos <span class="ml-1 text-xs opacity-75">({{ $counts['all'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'new']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('status') === 'new' ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Novos <span class="ml-1 text-xs opacity-75">({{ $counts['new'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('status') === 'read' ? 'bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Lidos <span class="ml-1 text-xs opacity-75">({{ $counts['read'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('status') === 'replied' ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Respondidos <span class="ml-1 text-xs opacity-75">({{ $counts['replied'] ?? 0 }})</span>
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'archived']) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('status') === 'archived' ? 'bg-gray-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Arquivados <span class="ml-1 text-xs opacity-75">({{ $counts['archived'] ?? 0 }})</span>
            </a>
        </div>
    </div>

    <div class="p-4 border-b">
        <form method="GET" action="{{ route('admin.contacts.index') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar contactos..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <button type="submit" class="px-4 py-2 text-white text-sm rounded-lg" style="background-color: #1B2A41;">
                    Pesquisar
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b bg-gray-50">
                    <th class="p-4 font-medium">Nome</th>
                    <th class="p-4 font-medium">Email</th>
                    <th class="p-4 font-medium">Assunto</th>
                    <th class="p-4 font-medium">Estado</th>
                    <th class="p-4 font-medium">Data</th>
                    <th class="p-4 font-medium text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts ?? [] as $contact)
                    <tr class="border-b last:border-0 hover:bg-gray-50">
                        <td class="p-4 font-medium text-gray-800">{{ $contact->name }}</td>
                        <td class="p-4 text-gray-600">{{ $contact->email }}</td>
                        <td class="p-4 text-gray-600">{{ Str::limit($contact->subject, 40) }}</td>
                        <td class="p-4">
                            @if($contact->status === 'new')
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Novo</span>
                            @elseif($contact->status === 'read')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Lido</span>
                            @elseif($contact->status === 'replied')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Respondido</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Arquivado</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este contacto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Nenhum contacto encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($contacts) && $contacts->hasPages())
        <div class="p-4 border-t">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection
