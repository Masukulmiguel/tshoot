@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-8" style="color: #1B2A41;">Análise de Visitantes</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Top Browsers</h3>
            <div class="space-y-3">
                @forelse($topBrowsers as $browser)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $browser->browser }}</span>
                        <span class="font-medium" style="color: #1B2A41;">{{ $browser->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="background-color: #D4A11D; width: {{ $browser->percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Top Sistemas Operacionais</h3>
            <div class="space-y-3">
                @forelse($topOs as $os)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $os->os }}</span>
                        <span class="font-medium" style="color: #1B2A41;">{{ $os->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="background-color: #D4A11D; width: {{ $os->percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Dispositivos</h3>
            <div class="space-y-3">
                @forelse($topDevices as $device)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $device->device }}</span>
                        <span class="font-medium" style="color: #1B2A41;">{{ $device->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="background-color: #D4A11D; width: {{ $device->percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Top Países</h3>
            <div class="space-y-3">
                @forelse($topCountries as $country)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $country->country }}</span>
                        <span class="font-medium" style="color: #1B2A41;">{{ $country->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="background-color: #D4A11D; width: {{ $country->percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Páginas Mais Visitadas</h3>
            <div class="space-y-3">
                @forelse($topPages as $page)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 truncate mr-2">{{ $page->page }}</span>
                        <span class="font-medium whitespace-nowrap" style="color: #1B2A41;">{{ $page->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full" style="background-color: #D4A11D; width: {{ $page->percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4" style="color: #1B2A41;">Visitantes Diários (Últimos 30 Dias)</h3>
            <div class="flex items-end gap-1 h-48">
                @forelse($dailyVisitors as $day)
                <div class="flex-1 flex flex-col items-center justify-end h-full">
                    <div class="w-full rounded-t" style="background-color: #D4A11D; height: {{ $day->percentage }}%"></div>
                    <span class="text-xs text-gray-500 mt-1">{{ $day->day }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-sm w-full text-center">Sem dados disponíveis.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
