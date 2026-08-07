@extends('layouts.admin')
@section('content')

{{-- Stats Row --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalContacts }}</p>
        <p class="text-xs text-gray-500 mt-1">Contactos recebidos</p>
    </div>

    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalVisitors }}</p>
        <p class="text-xs text-gray-500 mt-1">Visitantes únicos</p>
    </div>

    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">+{{ $newContacts }}</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalContacts - $newContacts }}</p>
        <p class="text-xs text-gray-500 mt-1">Contactos lidos</p>
    </div>

    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Galeria</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalImages }}</p>
        <p class="text-xs text-gray-500 mt-1">Imagens do site</p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Visitantes</h3>
                <p class="text-xs text-gray-500 mt-0.5">Últimos 14 dias</p>
            </div>
            <div class="flex items-center gap-1 text-xs text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                </svg>
                <span>Ativo</span>
            </div>
        </div>
        <div style="height:220px"><canvas id="visitorsChart"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Dispositivos</h3>
            <p class="text-xs text-gray-500 mt-0.5">Distribuição</p>
        </div>
        <div style="height:200px"><canvas id="devicesChart"></canvas></div>
    </div>
</div>

{{-- Second Charts Row --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Browsers</h3>
            <p class="text-xs text-gray-500 mt-0.5">Mais utilizados</p>
        </div>
        <div style="height:180px"><canvas id="browsersChart"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Países</h3>
            <p class="text-xs text-gray-500 mt-0.5">Origem dos visitantes</p>
        </div>
        <div style="height:180px"><canvas id="countriesChart"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 sm:col-span-2 lg:col-span-1">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Sistemas Operativos</h3>
            <p class="text-xs text-gray-500 mt-0.5">Distribuição</p>
        </div>
        <div style="height:180px"><canvas id="osChart"></canvas></div>
    </div>
</div>

{{-- Third Charts Row --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Páginas Populares</h3>
            <p class="text-xs text-gray-500 mt-0.5">Mais visitadas</p>
        </div>
        <div style="height:180px"><canvas id="pagesChart"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-900">Contactos</h3>
            <p class="text-xs text-gray-500 mt-0.5">Últimos 14 dias</p>
        </div>
        <div style="height:180px"><canvas id="contactsChart"></canvas></div>
    </div>
</div>

{{-- Tables --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    {{-- Recent Contacts --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Contactos Recentes</h3>
                    <p class="text-[11px] text-gray-500">Últimas mensagens recebidas</p>
                </div>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="text-xs font-medium text-gold hover:text-gold-dark transition-colors">Ver todos →</a>
        </div>
        <div id="contacts-list" class="divide-y divide-gray-50">
            @forelse($recentContacts as $contact)
                <a href="{{ route('admin.contacts.show', $contact) }}" class="table-row flex items-center gap-4 px-5 py-3.5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-gray-600">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($contact->name, 22) }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($contact->subject ?? 'Sem assunto', 35) }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($contact->status === 'new')
                            <span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-blue-50 text-blue-600">Novo</span>
                        @elseif($contact->status === 'read')
                            <span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-600">Lido</span>
                        @elseif($contact->status === 'replied')
                            <span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-600">Respondido</span>
                        @else
                            <span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-gray-50 text-gray-500">Arquivado</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="px-5 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Sem contactos ainda</p>
                </div>
            @endforelse
        </div>
        <div id="contacts-load-more" class="px-5 py-3 border-t border-gray-100 bg-gray-50/50" style="{{ $recentContacts->count() < 5 ? 'display:none' : '' }}">
            <button onclick="loadMoreContacts()" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-semibold hover:from-amber-600 hover:to-amber-700 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Carregar mais contactos
            </button>
        </div>
    </div>

    {{-- Recent Visitors --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Últimos Visitantes</h3>
                    <p class="text-[11px] text-gray-500">Atividade recente no site</p>
                </div>
            </div>
            <a href="{{ route('admin.visitors.index') }}" class="text-xs font-medium text-gold hover:text-gold-dark transition-colors">Ver todos →</a>
        </div>
        <div id="visitors-list" class="divide-y divide-gray-50">
            @forelse($recentVisitors as $visitor)
                <a href="{{ route('admin.visitors.show', $visitor) }}" class="table-row flex items-center gap-4 px-5 py-3.5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $visitor->ip_address ?? 'IP desconhecido' }}</p>
                        <p class="text-xs text-gray-500 truncate">
                            @if($visitor->city && $visitor->country)
                                {{ $visitor->city }}, {{ $visitor->country }}
                            @elseif($visitor->country)
                                {{ $visitor->country }}
                            @else
                                Localização desconhecida
                            @endif
                            · {{ $visitor->browser ?? '-' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full {{ $visitor->device === 'Mobile' ? 'bg-blue-50 text-blue-600' : ($visitor->device === 'Tablet' ? 'bg-purple-50 text-purple-600' : 'bg-gray-50 text-gray-600') }}">
                            {{ $visitor->device ?? '-' }}
                        </span>
                        <span class="text-[11px] text-gray-400 font-medium">{{ $visitor->pages_visited }}p</span>
                    </div>
                </a>
            @empty
                <div class="px-5 py-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Sem visitantes ainda</p>
                </div>
            @endforelse
        </div>
        <div id="visitors-load-more" class="px-5 py-3 border-t border-gray-100 bg-gray-50/50" style="{{ $recentVisitors->count() < 5 ? 'display:none' : '' }}">
            <button onclick="loadMoreVisitors()" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-semibold hover:from-blue-600 hover:to-blue-700 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Carregar mais visitantes
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const gold = '#D4A11D';
const goldLight = '#E8B931';
const navy = '#1B2A41';
const navyLight = '#243652';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { display: false }, ticks: { font: { size: 10, family: 'Inter' }, color: '#9CA3AF' } },
        y: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 10, family: 'Inter' }, color: '#9CA3AF' }, beginAtZero: true, border: { display: false } }
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
            backgroundColor: (ctx) => {
                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 220);
                gradient.addColorStop(0, 'rgba(212, 161, 29, 0.15)');
                gradient.addColorStop(1, 'rgba(212, 161, 29, 0.01)');
                return gradient;
            },
            fill: true,
            tension: 0.4,
            pointBackgroundColor: gold,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 3,
            pointHoverRadius: 6,
            borderWidth: 2.5
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
        datasets: [{
            data: deviceData,
            backgroundColor: [navy, gold, '#94A3B8'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 14, usePointStyle: true, pointStyle: 'circle', font: { size: 11, family: 'Inter' }, color: '#64748B' }
            }
        },
        cutout: '68%'
    }
});

const browserLabels = @json($visitorsByBrowser->pluck('browser'));
const browserData = @json($visitorsByBrowser->pluck('count'));
new Chart(document.getElementById('browsersChart'), {
    type: 'bar',
    data: {
        labels: browserLabels,
        datasets: [{
            data: browserData,
            backgroundColor: browserLabels.map((_, i) => i === 0 ? gold : navyLight),
            borderRadius: 6,
            barThickness: 18
        }]
    },
    options: {
        ...chartDefaults,
        indexAxis: 'y',
        scales: {
            x: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 10, family: 'Inter' }, color: '#9CA3AF' }, beginAtZero: true, border: { display: false } },
            y: { grid: { display: false }, ticks: { font: { size: 11, family: 'Inter' }, color: '#374151' } }
        }
    }
});

const countryLabels = @json($visitorsByCountry->pluck('country'));
const countryData = @json($visitorsByCountry->pluck('count'));
new Chart(document.getElementById('countriesChart'), {
    type: 'bar',
    data: {
        labels: countryLabels,
        datasets: [{
            data: countryData,
            backgroundColor: countryLabels.map((_, i) => i === 0 ? gold : navyLight),
            borderRadius: 6,
            barThickness: 18
        }]
    },
    options: {
        ...chartDefaults,
        indexAxis: 'y',
        scales: {
            x: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 10, family: 'Inter' }, color: '#9CA3AF' }, beginAtZero: true, border: { display: false } },
            y: { grid: { display: false }, ticks: { font: { size: 11, family: 'Inter' }, color: '#374151' } }
        }
    }
});

const osLabels = @json($visitorsByOS->pluck('os'));
const osData = @json($visitorsByOS->pluck('count'));
new Chart(document.getElementById('osChart'), {
    type: 'doughnut',
    data: {
        labels: osLabels,
        datasets: [{
            data: osData,
            backgroundColor: [navy, gold, '#94A3B8', '#CBD5E1', '#475569'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 14, usePointStyle: true, pointStyle: 'circle', font: { size: 11, family: 'Inter' }, color: '#64748B' }
            }
        },
        cutout: '68%'
    }
});

const pageLabels = @json($topPages->pluck('page'));
const pageData = @json($topPages->pluck('count'));
new Chart(document.getElementById('pagesChart'), {
    type: 'bar',
    data: {
        labels: pageLabels,
        datasets: [{
            data: pageData,
            backgroundColor: pageLabels.map((_, i) => i === 0 ? gold : navyLight),
            borderRadius: 6,
            barThickness: 18
        }]
    },
    options: {
        ...chartDefaults,
        indexAxis: 'y',
        scales: {
            x: { grid: { color: '#F1F5F9' }, ticks: { font: { size: 10, family: 'Inter' }, color: '#9CA3AF' }, beginAtZero: true, border: { display: false } },
            y: { grid: { display: false }, ticks: { font: { size: 10, family: 'Inter' }, color: '#374151' } }
        }
    }
});

const contactLabels = @json($contactsByDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m')));
const contactData = @json($contactsByDay->pluck('count'));
new Chart(document.getElementById('contactsChart'), {
    type: 'bar',
    data: {
        labels: contactLabels,
        datasets: [{
            data: contactData,
            backgroundColor: (ctx) => {
                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 180);
                gradient.addColorStop(0, navy);
                gradient.addColorStop(1, navyLight);
                return gradient;
            },
            borderRadius: 6,
            barThickness: 16
        }]
    },
    options: chartDefaults
});

// Dashboard pagination
let contactsPage = 1;
let visitorsPage = 1;

function getStatusBadge(status) {
    const badges = {
        'new': '<span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-blue-50 text-blue-600">Novo</span>',
        'read': '<span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-amber-50 text-amber-600">Lido</span>',
        'replied': '<span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-emerald-50 text-emerald-600">Respondido</span>',
    };
    return badges[status] || '<span class="px-2.5 py-1 text-[10px] font-semibold rounded-full bg-gray-50 text-gray-500">Arquivado</span>';
}

function getDeviceClass(device) {
    if (device === 'Mobile') return 'bg-blue-50 text-blue-600';
    if (device === 'Tablet') return 'bg-purple-50 text-purple-600';
    return 'bg-gray-50 text-gray-600';
}

function getLocation(visitor) {
    if (visitor.city && visitor.country) return visitor.city + ', ' + visitor.country;
    if (visitor.country) return visitor.country;
    return 'Localização desconhecida';
}

function loadMoreContacts() {
    contactsPage++;
    const btn = event.target.closest('button');
    btn.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> A carregar...';

    fetch('{{ route("admin.dashboard.moreContacts") }}?page=' + contactsPage)
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('contacts-list');
            data.contacts.forEach(c => {
                list.insertAdjacentHTML('beforeend', `
                    <a href="${c.show_url}" class="table-row flex items-center gap-4 px-5 py-3.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-gray-600">${c.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">${c.name}</p>
                            <p class="text-xs text-gray-500 truncate">${c.subject}</p>
                        </div>
                        <div class="flex-shrink-0">${getStatusBadge(c.status)}</div>
                    </a>
                `);
            });
            if (!data.hasMore) {
                document.getElementById('contacts-load-more').style.display = 'none';
            }
            btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg> Carregar mais contactos';
        });
}

function loadMoreVisitors() {
    visitorsPage++;
    const btn = event.target.closest('button');
    btn.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> A carregar...';

    fetch('{{ route("admin.dashboard.moreVisitors") }}?page=' + visitorsPage)
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('visitors-list');
            data.visitors.forEach(v => {
                list.insertAdjacentHTML('beforeend', `
                    <a href="${v.show_url}" class="table-row flex items-center gap-4 px-5 py-3.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">${v.ip_address}</p>
                            <p class="text-xs text-gray-500 truncate">${getLocation(v)} · ${v.browser}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full ${getDeviceClass(v.device)}">${v.device}</span>
                            <span class="text-[11px] text-gray-400 font-medium">${v.pages_visited}p</span>
                        </div>
                    </a>
                `);
            });
            if (!data.hasMore) {
                document.getElementById('visitors-load-more').style.display = 'none';
            }
            btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg> Carregar mais visitantes';
        });
}
</script>
@endsection