<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Dashboard' }} - TSHOOT</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/simbole.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4A11D',
                        'gold-light': '#E8B931',
                        'gold-dark': '#B8920F',
                        navy: '#1B2A41',
                        'navy-light': '#243652',
                        'navy-dark': '#141F33',
                        surface: '#F8FAFC',
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
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        .sidebar { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-item {
            position: relative;
            transition: all 0.2s ease;
            border-radius: 0.75rem;
            margin: 0 12px;
            padding: 10px 14px;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(212, 161, 29, 0.2) 0%, rgba(212, 161, 29, 0.1) 100%);
            box-shadow: 0 0 0 1px rgba(212, 161, 29, 0.2);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: #D4A11D;
            border-radius: 0 4px 4px 0;
        }
        .nav-item.active .nav-icon { color: #D4A11D; }

        .stat-card {
            transition: all 0.3s ease;
            border: 1px solid #E2E8F0;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0,0,0,0.1);
            border-color: #D4A11D;
        }

        .table-row { transition: background 0.15s ease; }
        .table-row:hover { background: #F8FAFC; }

        .badge {
            transition: all 0.2s ease;
            font-size: 11px;
            font-weight: 600;
        }

        @media (max-width: 640px) {
            .sidebar-brand-text { display: none; }
            #sidebar { width: 70px !important; }
            #sidebar .nav-item { padding: 10px; justify-content: center; }
            #sidebar .nav-item span,
            #sidebar .nav-item .badge,
            #sidebar .user-info-text { display: none; }
            #sidebar .nav-item { margin: 4px 8px; }
        }

        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }
        @keyframes slideOut { from { transform: translateX(0); } to { transform: translateX(-100%); } }
        .sidebar-open { animation: slideIn 0.3s ease forwards; }
        .sidebar-closed { animation: slideOut 0.3s ease forwards; }
        .fade-in { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        /* Loading Screen */
        .admin-loader {
            position: fixed; inset: 0;
            background: linear-gradient(135deg, #1B2A41 0%, #243652 100%);
            z-index: 99999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .admin-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .admin-loader-logo { width: 80px; height: auto; animation: loaderPulse 1.5s ease-in-out infinite; }
        .admin-loader-bar { width: 160px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px; margin-top: 2rem; overflow: hidden; }
        .admin-loader-bar-fill { height: 100%; background: linear-gradient(90deg, #D4A11D, #E8B931); border-radius: 3px; animation: loaderFill 1.5s ease-in-out infinite; }
        @keyframes loaderPulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.05); opacity: 0.7; } }
        @keyframes loaderFill { 0% { width: 0%; margin-left: 0; } 50% { width: 100%; margin-left: 0; } 100% { width: 0%; margin-left: 100%; } }

        .card { transition: all 0.2s ease; border: 1px solid #E2E8F0; }
        .card:hover { border-color: #CBD5E1; }
    </style>
    @stack('styles')
</head>
<body class="bg-surface text-gray-800 antialiased">

    <div class="admin-loader" id="adminLoader">
        <img src="{{ asset('assets/img/simbole.png') }}" alt="Loading" class="admin-loader-logo" />
        <div class="admin-loader-bar">
            <div class="admin-loader-bar-fill"></div>
        </div>
        <p class="text-white/40 text-xs mt-4 tracking-widest uppercase">Carregando...</p>
    </div>

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden backdrop-blur-sm" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="sidebar fixed left-0 top-0 h-full bg-navy z-50 w-[260px] flex flex-col -translate-x-full lg:translate-x-0">
        {{-- Logo --}}
        <div class="h-16 flex items-center px-5 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gold/20 flex items-center justify-center">
                    <img src="{{ asset('assets/img/simbole.png') }}" alt="TSHOOT" class="h-6 w-6 object-contain">
                </div>
                <div class="sidebar-brand-text">
                    <span class="text-white font-bold text-sm tracking-wide">TSHOOT</span>
                    <p class="text-[10px] text-white/40 font-medium">Painel de Controlo</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="px-5 mb-2">
                <span class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Principal</span>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.dashboard') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Dashboard</span>
            </a>

            <a href="{{ route('admin.contacts.index') }}"
               class="nav-item flex items-center justify-between {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.contacts.*') ? 'text-gold' : 'text-white/50' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-white/80">Contactos</span>
                </div>
                @if(isset($newContacts) && $newContacts > 0)
                    <span class="badge bg-gold text-navy px-2 py-0.5 rounded-full">
                        {{ $newContacts }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.visitors.index') }}"
               class="nav-item flex items-center justify-between {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.visitors.*') ? 'text-gold' : 'text-white/50' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-white/80">Visitantes</span>
                </div>
                @if(isset($newVisitors) && $newVisitors > 0)
                    <span class="badge bg-gold text-navy px-2 py-0.5 rounded-full">
                        {{ $newVisitors }}
                    </span>
                @endif
            </a>

            <div class="px-5 mt-5 mb-2">
                <span class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Conteúdo</span>
            </div>

            <a href="{{ route('admin.banners.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.banners.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Banners</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.services.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.1-5.1m5.1 5.1L17.25 9.5m-5.83 5.67l5.1-5.1M3.75 12h.008v.008H3.75V12zm16.5 0h.008v.008h-.008V12zM12 3.75v.008V3.75zm0 16.5v.008V20.25z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Serviços</span>
            </a>

            <a href="{{ route('admin.posts.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.posts.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Blog</span>
            </a>

            <a href="{{ route('admin.images.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.images.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.images.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Imagens</span>
            </a>

            <a href="{{ route('admin.partners.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.partners.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Parceiros</span>
            </a>

            <a href="{{ route('admin.social-links.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.social-links.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Redes Sociais</span>
            </a>

            <div class="px-5 mt-5 mb-2">
                <span class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Sistema</span>
            </div>

            <a href="{{ route('admin.settings.index') }}"
               class="nav-item flex items-center gap-3 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <div class="nav-icon w-5 h-5 flex items-center justify-center {{ request()->routeIs('admin.settings.*') ? 'text-gold' : 'text-white/50' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Configurações</span>
            </a>

            <a href="https://tshoot.vercel.app" target="_blank"
               class="nav-item flex items-center gap-3">
                <div class="nav-icon w-5 h-5 flex items-center justify-center text-green-400">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white/80">Ver Site</span>
            </a>
        </nav>

        {{-- User Info --}}
        <div class="border-t border-white/5 p-3">
            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/5 transition-colors">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center flex-shrink-0 shadow-lg shadow-gold/20">
                    <span class="text-navy font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </span>
                </div>
                <div class="user-info-text flex-1 min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-white/40 text-[11px] truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <div class="user-info-text flex items-center gap-1">
                    <a href="{{ route('admin.password') }}" class="w-7 h-7 flex items-center justify-center rounded-lg text-white/30 hover:text-gold hover:bg-white/5 transition-colors" title="Alterar Senha">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-white/30 hover:text-red-400 hover:bg-white/5 transition-colors" title="Sair">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="lg:ml-[260px] min-h-screen flex flex-col">

        {{-- Top Bar --}}
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-200/60 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                {{-- Mobile Menu Button --}}
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-navy hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                {{-- Page Title --}}
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-navy">{{ $pageTitle ?? 'Dashboard' }}</h1>
                    @if(isset($pageSubtitle))
                        <p class="text-xs text-gray-500">{{ $pageSubtitle }}</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Search --}}
                <button class="p-2.5 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-xl transition-colors hidden sm:flex">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </button>

                {{-- Notifications --}}
                <button class="relative p-2.5 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                    @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    @endif
                </button>

                {{-- Divider --}}
                <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>

                {{-- User Menu --}}
                <div class="flex items-center gap-3 pl-1">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-navy to-navy-light flex items-center justify-center ring-2 ring-white shadow-sm">
                        <span class="text-white font-semibold text-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-6 pt-4 space-y-3">
            @if(session('success'))
                <div class="fade-in flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl shadow-sm" role="alert">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium flex-1">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="fade-in flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm" role="alert">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium flex-1">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="fade-in flex items-center gap-3 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-2xl shadow-sm" role="alert">
                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium flex-1">{{ session('warning') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-amber-400 hover:text-amber-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="fade-in flex items-center gap-3 p-4 bg-sky-50 border border-sky-200 text-sky-700 rounded-2xl shadow-sm" role="alert">
                    <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium flex-1">{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-sky-400 hover:text-sky-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="fade-in flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm" role="alert">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-sm mb-1">Ocorreram os seguintes erros:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 p-4 lg:p-6">
            {{-- Page Title (Mobile) --}}
            @if(isset($pageTitle) || isset($pageActions))
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:hidden">
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

            @if(isset($pageActions))
                <div class="hidden sm:flex items-center justify-end gap-3 mb-6">
                    {{ $pageActions }}
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200/60 bg-white/50">
            <div class="px-4 lg:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} <span class="font-semibold text-navy">TSHOOT Soluções Tecnológicas</span>
                </p>
                <p class="text-xs text-gray-400">
                    Desenvolvido por <a href="https://wa.me/244931585686" target="_blank" class="font-semibold text-gold hover:underline">CodingLife Dev</a>
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

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var loader = document.getElementById('adminLoader');
                if (loader) loader.classList.add('hidden');
            }, 1200);

            document.querySelectorAll('.fade-in').forEach(function(el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(function() { el.remove(); }, 300);
                }, 5000);
            });
        });

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