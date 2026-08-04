@extends('layouts.admin')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-navy">Conteúdo do Site</h1>
        <p class="text-sm text-gray-500 mt-1">Editar textos, títulos e descrições de cada secção</p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @php
    $sectionLabels = [
        'hero' => ['icon' => 'fas fa-image', 'color' => 'bg-gold/10 text-gold', 'label' => 'Hero / Banner Principal'],
        'about' => ['icon' => 'fas fa-info-circle', 'color' => 'bg-blue-50 text-blue-600', 'label' => 'Sobre Nós'],
        'services' => ['icon' => 'fas fa-cogs', 'color' => 'bg-green-50 text-green-600', 'label' => 'Serviços'],
        'how_it_works' => ['icon' => 'fas fa-tasks', 'color' => 'bg-purple-50 text-purple-600', 'label' => 'Como Trabalhamos'],
        'infra' => ['icon' => 'fas fa-network-wired', 'color' => 'bg-red-50 text-red-600', 'label' => 'Infraestrutura'],
        'partners' => ['icon' => 'fas fa-handshake', 'color' => 'bg-amber-50 text-amber-600', 'label' => 'Parceiros'],
        'contact' => ['icon' => 'fas fa-envelope', 'color' => 'bg-sky-50 text-sky-600', 'label' => 'Contacto'],
        'footer' => ['icon' => 'fas fa-shoe-prints', 'color' => 'bg-gray-100 text-gray-600', 'label' => 'Rodapé'],
    ];
    @endphp

    @foreach($sectionLabels as $key => $info)
        <a href="{{ route('admin.content.edit', $key) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-gold/30 transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $info['color'] }}">
                    <i class="{{ $info['icon'] }} text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-gold transition-colors">{{ $info['label'] }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ isset($sections[$key]) ? $sections[$key]->count() : 0 }} campos</p>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection
