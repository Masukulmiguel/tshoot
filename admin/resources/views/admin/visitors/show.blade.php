@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('admin.visitors.index') }}" class="inline-flex items-center text-sm mb-6 hover:underline" style="color: #D4A11D;">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-bold mb-4" style="color: #1B2A41;">Informações do Visitante</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">IP</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->ip }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">País</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->country }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Cidade</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->city }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Browser</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->browser }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Sistema Operacional</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->os }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Dispositivo</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->device }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Referrer</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->referrer ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Landing Page</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->landing_page }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Páginas Visitadas</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->pages_count }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Primeira Visita</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->first_visit->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Última Visita</p>
                <p class="font-medium" style="color: #1B2A41;">{{ $visitor->last_visit->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold" style="color: #1B2A41;">Registros de Visitas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background-color: #1B2A41;">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Página</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Referrer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($visitor->visitLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->page }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->referrer ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhum registro encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $visitor->visitLogs->links() }}
        </div>
    </div>
</div>
@endsection
