@extends('layouts.admin')
@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Visitantes</h1>
        <p class="text-sm text-gray-500 mt-0.5">Acompanhe os visitantes do seu site</p>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Todos os visitantes</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Hoje</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $todayVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Visitantes hoje</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Semana</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $weekVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Esta semana</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Mês</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $monthVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1">Este mês</p>
    </div>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <div class="p-4">
        <form action="{{ route('admin.visitors.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por IP, país, cidade..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors">
                </div>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors">
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors">
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-navy bg-gold rounded-xl hover:bg-gold-light transition-colors shadow-sm">
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">IP</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">País</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cidade</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Browser</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">OS</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Device</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Páginas</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Última Visita</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($visitors as $visitor)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <span class="font-mono text-sm font-semibold text-gray-900">{{ $visitor->ip_address }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-600">{{ $visitor->country ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-600">{{ $visitor->city ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-600">{{ $visitor->browser ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-600">{{ $visitor->os ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full {{ $visitor->device === 'Mobile' ? 'bg-blue-50 text-blue-600' : ($visitor->device === 'Tablet' ? 'bg-purple-50 text-purple-600' : 'bg-gray-50 text-gray-600') }}">
                                {{ $visitor->device ?? '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm font-semibold text-gray-900">{{ $visitor->pages_visited }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs text-gray-500">{{ $visitor->last_visit->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.visitors.show', $visitor) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Excluir">
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
                        <td colspan="9" class="px-5 py-16 text-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Nenhum visitante encontrado</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($visitors->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                A mostrar <span class="font-semibold text-gray-700">{{ $visitors->firstItem() }}</span>
                a <span class="font-semibold text-gray-700">{{ $visitors->lastItem() }}</span>
                de <span class="font-semibold text-gray-700">{{ $visitors->total() }}</span> visitantes
            </p>
            <div class="flex items-center gap-1">
                @if($visitors->onFirstPage())
                    <span class="px-3 py-1.5 text-xs font-medium text-gray-300 bg-gray-100 rounded-lg cursor-not-allowed">Anterior</span>
                @else
                    <a href="{{ $visitors->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        ← Anterior
                    </a>
                @endif

                @foreach($visitors->getUrlRange(max(1, $visitors->currentPage() - 2), min($visitors->lastPage(), $visitors->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-xs font-medium rounded-lg transition-colors {{ $page == $visitors->currentPage() ? 'bg-gold text-navy' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($visitors->hasMorePages())
                    <a href="{{ $visitors->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-white bg-gold rounded-lg hover:bg-gold-light transition-colors shadow-sm">
                        Próximo →
                    </a>
                @else
                    <span class="px-3 py-1.5 text-xs font-medium text-gray-300 bg-gray-100 rounded-lg cursor-not-allowed">Próximo</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection