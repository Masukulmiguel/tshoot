@extends('layouts.admin')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Banners</h1>
        <p class="text-sm text-gray-500 mt-1">Gerir os slides do hero do site</p>
    </div>
    <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Novo Banner
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b border-gray-100 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Imagem</th>
                    <th class="px-5 py-3 font-medium">Título</th>
                    <th class="px-5 py-3 font-medium">Subtítulo</th>
                    <th class="px-5 py-3 font-medium">Botão</th>
                    <th class="px-5 py-3 font-medium">Ordem</th>
                    <th class="px-5 py-3 font-medium">Estado</th>
                    <th class="px-5 py-3 font-medium text-right">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            @if($banner->image)
                                <img src="{{ str_starts_with($banner->image, 'http') ? $banner->image : asset('uploads/' . $banner->image) }}" alt="" class="w-20 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">Sem imagem</div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $banner->title }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ Str::limit($banner->subtitle ?? '-', 40) }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $banner->button_text ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $banner->order }}</td>
                        <td class="px-5 py-3">
                            @if($banner->active)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-50 text-green-600">Activo</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Eliminar este banner?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-12 text-gray-400 text-center">Nenhum banner criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
