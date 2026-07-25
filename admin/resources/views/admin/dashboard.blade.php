@extends('layouts.admin')
@section('content')

<div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4 mb-4 lg:mb-5">
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-lg flex items-center justify-center" style="background-color: #D4A11D15;">
                <svg class="w-4 h-4 lg:w-5 lg:h-5" style="color: #D4A11D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-[9px] lg:text-[10px] text-gray-400 uppercase tracking-wide">Contactos</p>
                <p class="text-lg lg:text-xl font-bold text-gray-900">{{ $totalContacts }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-lg flex items-center justify-center bg-blue-50">
                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <p class="text-[9px] lg:text-[10px] text-gray-400 uppercase tracking-wide">Visitantes</p>
                <p class="text-lg lg:text-xl font-bold text-gray-900">{{ $totalVisitors }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-lg flex items-center justify-center bg-green-50">
                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div>
                <p class="text-[9px] lg:text-[10px] text-gray-400 uppercase tracking-wide">Novos</p>
                <p class="text-lg lg:text-xl font-bold text-gray-900">{{ $newContacts }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-lg flex items-center justify-center bg-purple-50">
                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[9px] lg:text-[10px] text-gray-400 uppercase tracking-wide">Imagens</p>
                <p class="text-lg lg:text-xl font-bold text-gray-900">{{ $totalImages }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-3 lg:gap-4 mb-4 lg:mb-5">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Visitantes - 14 dias</h3>
        <div style="height:200px"><canvas id="visitorsChart"></canvas></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Dispositivos</h3>
        <div style="height:200px"><canvas id="devicesChart"></canvas></div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4 mb-4 lg:mb-5">
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Browsers</h3>
        <div style="height:180px"><canvas id="browsersChart"></canvas></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Países</h3>
        <div style="height:180px"><canvas id="countriesChart"></canvas></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100 sm:col-span-2 lg:col-span-1">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Sistemas Operativos</h3>
        <div style="height:180px"><canvas id="osChart"></canvas></div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4 mb-4 lg:mb-5">
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Páginas Mais Visitadas</h3>
        <div style="height:180px"><canvas id="pagesChart"></canvas></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-3 lg:p-4 border border-gray-100">
        <h3 class="text-xs font-semibold text-gray-700 mb-2 lg:mb-3">Contactos - 14 dias</h3>
        <div style="height:180px"><canvas id="contactsChart"></canvas></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 lg:p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xs font-semibold text-gray-700">Contactos Recentes</h3>
            <a href="{{ route('admin.contacts.index') }}" class="text-[10px] font-medium text-gold hover:underline">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="px-3 lg:px-4 py-2 font-medium">Nome</th>
                        <th class="px-3 lg:px-4 py-2 font-medium hidden sm:table-cell">Assunto</th>
                        <th class="px-3 lg:px-4 py-2 font-medium">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentContacts as $contact)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 cursor-pointer" onclick="location.href='{{ route('admin.contacts.show', $contact) }}'">
                            <td class="px-3 lg:px-4 py-2.5 font-medium text-gray-900">{{ Str::limit($contact->name, 20) }}</td>
                            <td class="px-3 lg:px-4 py-2.5 text-gray-500 hidden sm:table-cell">{{ Str::limit($contact->subject ?? '-', 30) }}</td>
                            <td class="px-3 lg:px-4 py-2.5">
                                @if($contact->status === 'new')
                                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-blue-50 text-blue-600">Novo</span>
                                @elseif($contact->status === 'read')
                                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-amber-50 text-amber-600">Lido</span>
                                @elseif($contact->status === 'replied')
                                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-50 text-green-600">Respondido</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-gray-50 text-gray-500">Arquivado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-6 text-gray-400 text-center">Sem contactos ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-3 lg:p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xs font-semibold text-gray-700">Últimos Visitantes</h3>
            <a href="{{ route('admin.visitors.index') }}" class="text-[10px] font-medium text-gold hover:underline">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-left text-gray-400 border-b border-gray-50">
                        <th class="px-3 lg:px-4 py-2 font-medium">IP</th>
                        <th class="px-3 lg:px-4 py-2 font-medium hidden sm:table-cell">Localização</th>
                        <th class="px-3 lg:px-4 py-2 font-medium">Browser</th>
                        <th class="px-3 lg:px-4 py-2 font-medium hidden md:table-cell">Disp.</th>
                        <th class="px-3 lg:px-4 py-2 font-medium">Pág.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVisitors as $visitor)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 cursor-pointer" onclick="location.href='{{ route('admin.visitors.show', $visitor) }}'">
                            <td class="px-3 lg:px-4 py-2.5 font-medium text-gray-900">{{ $visitor->ip_address ?? '-' }}</td>
                            <td class="px-3 lg:px-4 py-2.5 text-gray-500 hidden sm:table-cell">
                                @if($visitor->city && $visitor->country)
                                    {{ $visitor->city }}, {{ $visitor->country }}
                                @elseif($visitor->country)
                                    {{ $visitor->country }}
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-3 lg:px-4 py-2.5 text-gray-500">{{ $visitor->browser ?? '-' }}</td>
                            <td class="px-3 lg:px-4 py-2.5 hidden md:table-cell">
                                <span class="px-1.5 py-0.5 text-[10px] rounded {{ $visitor->device === 'Mobile' ? 'bg-blue-50 text-blue-600' : ($visitor->device === 'Tablet' ? 'bg-purple-50 text-purple-600' : 'bg-gray-50 text-gray-600') }}">
                                    {{ $visitor->device ?? '-' }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-4 py-2.5 font-medium text-gray-700">{{ $visitor->pages_visited }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-6 text-gray-400 text-center">Sem visitantes ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const gold = '#D4A11D';
const navy = '#1B2A41';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#9CA3AF' } },
        y: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 10 }, color: '#9CA3AF' }, beginAtZero: true }
    }
};

const visitorLabels = @json($visitorsByDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m')));
const visitorData = @json($visitorsByDay->pluck('count'));
new Chart(document.getElementById('visitorsChart'), {
    type: 'line',
    data: {
        labels: visitorLabels,
        datasets: [{
            data: visitorData,
            borderColor: gold,
            backgroundColor: gold + '15',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: gold,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 3,
            pointHoverRadius: 5
        }]
    },
    options: chartDefaults
});

const deviceLabels = @json($visitorsByDevice->pluck('device'));
const deviceData = @json($visitorsByDevice->pluck('count'));
new Chart(document.getElementById('devicesChart'), {
    type: 'doughnut',
    data: {
        labels: deviceLabels,
        datasets: [{ data: deviceData, backgroundColor: [navy, gold, '#6B7280'], borderWidth: 0 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } } },
        cutout: '65%'
    }
});

const browserLabels = @json($visitorsByBrowser->pluck('browser'));
const browserData = @json($visitorsByBrowser->pluck('count'));
new Chart(document.getElementById('browsersChart'), {
    type: 'bar',
    data: {
        labels: browserLabels,
        datasets: [{ data: browserData, backgroundColor: browserLabels.map((_, i) => i === 0 ? gold : navy), borderRadius: 4, barThickness: 20 }]
    },
    options: { ...chartDefaults, indexAxis: 'y', scales: { x: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 10 }, color: '#9CA3AF' }, beginAtZero: true }, y: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#374151' } } } }
});

const countryLabels = @json($visitorsByCountry->pluck('country'));
const countryData = @json($visitorsByCountry->pluck('count'));
new Chart(document.getElementById('countriesChart'), {
    type: 'bar',
    data: {
        labels: countryLabels,
        datasets: [{ data: countryData, backgroundColor: countryLabels.map((_, i) => i === 0 ? gold : navy), borderRadius: 4, barThickness: 20 }]
    },
    options: { ...chartDefaults, indexAxis: 'y', scales: { x: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 10 }, color: '#9CA3AF' }, beginAtZero: true }, y: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#374151' } } } }
});

const osLabels = @json($visitorsByOS->pluck('os'));
const osData = @json($visitorsByOS->pluck('count'));
new Chart(document.getElementById('osChart'), {
    type: 'doughnut',
    data: {
        labels: osLabels,
        datasets: [{ data: osData, backgroundColor: [navy, gold, '#6B7280', '#D1D5DB', '#374151'], borderWidth: 0 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } } },
        cutout: '65%'
    }
});

const pageLabels = @json($topPages->pluck('page'));
const pageData = @json($topPages->pluck('count'));
new Chart(document.getElementById('pagesChart'), {
    type: 'bar',
    data: {
        labels: pageLabels,
        datasets: [{ data: pageData, backgroundColor: pageLabels.map((_, i) => i === 0 ? gold : navy), borderRadius: 4, barThickness: 20 }]
    },
    options: { ...chartDefaults, indexAxis: 'y', scales: { x: { grid: { color: '#F3F4F6' }, ticks: { font: { size: 10 }, color: '#9CA3AF' }, beginAtZero: true }, y: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#374151' } } } }
});

const contactLabels = @json($contactsByDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m')));
const contactData = @json($contactsByDay->pluck('count'));
new Chart(document.getElementById('contactsChart'), {
    type: 'bar',
    data: {
        labels: contactLabels,
        datasets: [{ data: contactData, backgroundColor: navy, borderRadius: 4, barThickness: 16 }]
    },
    options: chartDefaults
});
</script>
@endsection
