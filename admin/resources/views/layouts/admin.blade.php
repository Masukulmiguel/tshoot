<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Dashboard' }} - TSHOOT CRM</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/simbole.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4A11D',
                        navy: '#1B2A41',
                        'navy-light': '#243652',
                        'navy-dark': '#141F33',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1B2A41; border-radius: 3px; }
        .sidebar-transition { transition: transform 0.3s ease-in-out, width 0.3s ease-in-out; }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover { background: rgba(212, 161, 29, 0.1); }
        .nav-link.active { background: rgba(212, 161, 29, 0.15); border-right: 3px solid #D4A11D; }
        .nav-link.active svg { color: #D4A11D; }
        .badge { transition: all 0.2s ease; }
        @media (max-width: 640px) {
            .sidebar-brand-text { display: none; }
            #sidebar { width: 220px !important; }
        }
        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }
        @keyframes slideOut { from { transform: translateX(0); } to { transform: translateX(-100%); } }
        .sidebar-open { animation: slideIn 0.3s ease forwards; }
        .sidebar-closed { animation: slideOut 0.3s ease forwards; }
        .fade-in { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Loading Screen */
        .admin-loader { position: fixed; inset: 0; background: #1B2A41; z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease, visibility 0.5s ease; }
        .admin-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .admin-loader-logo { width: 100px; height: auto; animation: loaderPulse 1.5s ease-in-out infinite; }
        .admin-loader-bar { width: 180px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px; margin-top: 2rem; overflow: hidden; }
        .admin-loader-bar-fill { height: 100%; background: #D4A11D; border-radius: 3px; animation: loaderFill 1.5s ease-in-out infinite; }
        @keyframes loaderPulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.05); opacity: 0.7; } }
        @keyframes loaderFill { 0% { width: 0%; margin-left: 0; } 50% { width: 100%; margin-left: 0; } 100% { width: 0%; margin-left: 100%; } }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="admin-loader" id="adminLoader">
        <img src="{{ asset('assets/img/simbole.png') }}" alt="Loading" class="admin-loader-logo" />
        <div class="admin-loader-bar">
            <div class="admin-loader-bar-fill"></div>
        </div>
        <p class="text-white/30 text-xs mt-4 tracking-widest uppercase">Carregando...</p>
    </div>

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed left-0 top-0 h-full bg-navy z-50 sidebar-transition w-[250px] flex flex-col -translate-x-full lg:translate-x-0">
        {{-- Logo --}}
        <div class="h-16 flex items-center px-6 border-b border-navy-light/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/simbole.png') }}" alt="TSHOOT Logo" class="h-9 w-9 object-contain">
                <span class="sidebar-brand-text text-gold font-bold text-lg tracking-wide">TSHOOT CRM</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</span>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}"
               class="nav-link flex items-center justify-between px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.contacts.*') ? 'text-gold' : '' }}"></i>
                    <span class="font-medium text-sm">Contactos</span>
                </div>
                @if(isset($newContacts) && $newContacts > 0)
                    <span class="badge bg-gold text-navy text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $newContacts }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.visitors.index') }}"
               class="nav-link flex items-center justify-between px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chart-line flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.visitors.*') ? 'text-gold' : '' }}"></i>
                    <span class="font-medium text-sm">Visitantes</span>
                </div>
                @if(isset($newVisitors) && $newVisitors > 0)
                    <span class="badge bg-gold text-navy text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $newVisitors }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.banners.index') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="fas fa-panorama flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.banners.*') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Banners</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="fas fa-bolt flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.services.*') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Serviços</span>
            </a>

            <a href="{{ route('admin.team.index') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                <i class="fas fa-users flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.team.*') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Equipa</span>
            </a>

            <a href="{{ route('admin.posts.index') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.posts.*') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Blog</span>
            </a>

            <a href="{{ route('admin.settings.index') }}"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog flex-shrink-0 w-5 text-center {{ request()->routeIs('admin.settings.*') ? 'text-gold' : '' }}"></i>
                <span class="font-medium text-sm">Configurações</span>
            </a>

            <div class="px-4 my-3">
                <div class="border-t border-navy-light/50"></div>
            </div>

            <a href="https://tshoot.vercel.app" target="_blank"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white">
                <i class="fas fa-external-link-alt flex-shrink-0 w-5 text-center text-green-400"></i>
                <span class="font-medium text-sm">Ver Site</span>
            </a>
        </nav>

        {{-- User Info --}}
        <div class="border-t border-navy-light/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                    <span class="text-gold font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-gray-400 text-xs truncate">{{ Auth::user()->email ?? 'admin@tshoot.co.ao' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors" title="Sair">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="lg:ml-[250px] min-h-screen flex flex-col">

        {{-- Top Bar --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                {{-- Mobile Menu Button --}}
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-navy transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Breadcrumbs --}}
                <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-navy transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>
                        </svg>
                    </a>
                    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                        @foreach($breadcrumbs as $label => $url)
                            <span>/</span>
                            @if($loop->last)
                                <span class="text-navy font-medium">{{ $label }}</span>
                            @else
                                <a href="{{ $url }}" class="hover:text-navy transition-colors">{{ $label }}</a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Notifications --}}
                <button class="relative p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>

                {{-- User Dropdown (Mobile) --}}
                <div class="hidden sm:flex items-center gap-3 pl-3 border-l border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-navy flex items-center justify-center">
                        <span class="text-white font-medium text-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-6 pt-4 space-y-3">
            @if(session('success'))
                <div class="fade-in flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="fade-in flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="fade-in flex items-center gap-3 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">{{ session('warning') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="fade-in flex items-center gap-3 p-4 bg-sky-50 border border-sky-200 text-sky-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-sky-500 hover:text-sky-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="fade-in flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-medium text-sm mb-1">Ocorreram os seguintes erros:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 p-4 lg:p-6">
            {{-- Page Title --}}
            @if(isset($pageTitle) || isset($pageActions))
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-navy">{{ $pageTitle ?? 'Dashboard' }}</h1>
                        @if(isset($pageSubtitle))
                            <p class="text-sm text-gray-500 mt-1">{{ $pageSubtitle }}</p>
                        @endif
                    </div>
                    @if(isset($pageActions))
                        <div class="flex items-center gap-3">
                            {{ $pageActions }}
                        </div>
                    @endif
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 bg-white">
            <div class="px-4 lg:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} <span class="font-semibold text-navy">TSHOOT Soluções Tecnológicas</span>. Todos os direitos reservados.
                </p>
                <p class="text-xs text-gray-400">
                    Desenvolvido por <a href="https://wa.me/244935603163" target="_blank" class="font-semibold text-gold hover:underline">CodingLife Dev</a>
                </p>
            </div>
        </footer>
    </div>

    {{-- Scripts --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth < 1024) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
        }

        // Auto-dismiss flash messages & Loader
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loader after 1.5s
            setTimeout(function() {
                var loader = document.getElementById('adminLoader');
                if (loader) loader.classList.add('hidden');
            }, 1500);

            document.querySelectorAll('.fade-in').forEach(function(el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.3s ease';
                    el.style.opacity = '0';
                    setTimeout(function() { el.remove(); }, 300);
                }, 5000);
            });
        });

        // Handle window resize - close sidebar on desktop
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
