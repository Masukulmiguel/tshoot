@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Serviços</h1>
        <p class="text-sm text-gray-500 mt-1">Gerir os serviços apresentados no site</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Novo Serviço
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-100 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Ícone</th>
                    <th class="px-5 py-3 font-medium">Título</th>
                    <th class="px-5 py-3 font-medium">Descrição</th>
                    <th class="px-5 py-3 font-medium">Categoria</th>
                    <th class="px-5 py-3 font-medium">Ordem</th>
                    <th class="px-5 py-3 font-medium">Estado</th>
                    <th class="px-5 py-3 font-medium text-right">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            @if($service->icon)
                                <div class="w-10 h-10 bg-gold/10 rounded-lg flex items-center justify-center">
                                    <i class="{{ $service->icon }} text-gold"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $service->title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ Str::limit($service->short_description ?? $service->description, 50) }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-navy/10 text-navy">{{ $service->category }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $service->sort_order }}</td>
                        <td class="px-5 py-3">
                            @if($service->is_active)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-50 text-green-600">Activo</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Eliminar este serviço?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-12 text-gray-400 text-center">Nenhum serviço criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
