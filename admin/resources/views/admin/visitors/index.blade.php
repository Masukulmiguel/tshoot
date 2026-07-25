@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold" style="color: #1B2A41;">Visitantes</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4" style="border-left-color: #D4A11D;">
            <p class="text-sm text-gray-500 uppercase">Total</p>
            <p class="text-2xl font-bold" style="color: #1B2A41;">{{ $totalVisitors ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4" style="border-left-color: #D4A11D;">
            <p class="text-sm text-gray-500 uppercase">Hoje</p>
            <p class="text-2xl font-bold" style="color: #1B2A41;">{{ $todayVisitors ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4" style="border-left-color: #D4A11D;">
            <p class="text-sm text-gray-500 uppercase">Esta Semana</p>
            <p class="text-2xl font-bold" style="color: #1B2A41;">{{ $weekVisitors ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4" style="border-left-color: #D4A11D;">
            <p class="text-sm text-gray-500 uppercase">Este Mês</p>
            <p class="text-2xl font-bold" style="color: #1B2A41;">{{ $monthVisitors ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-8 p-6">
        <form action="{{ route('admin.visitors.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar visitante..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4A11D] focus:border-transparent">
                </div>
                <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4A11D] focus:border-transparent">
                </div>
                <div class="flex gap-2">
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D4A11D] focus:border-transparent">
                    <button type="submit" class="px-4 py-2 rounded-lg text-white font-medium" style="background-color: #D4A11D;">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background-color: #1B2A41;">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">País</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Cidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Browser</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">OS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Páginas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Última Visita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($visitors as $visitor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->ip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->country }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->city }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->browser }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->os }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->device }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->pages_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visitor->last_visit->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.visitors.show', $visitor->id) }}"
                                    class="text-[#D4A11D] hover:underline">Ver</a>
                                <form action="{{ route('admin.visitors.destroy', $visitor->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">Nenhum visitante encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $visitors->links() }}
        </div>
    </div>
</div>
@endsection
