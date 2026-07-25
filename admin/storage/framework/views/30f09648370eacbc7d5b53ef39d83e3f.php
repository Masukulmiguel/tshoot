<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($pageTitle ?? 'Dashboard'); ?> - TSHOOT CRM</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/simbole.png')); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="admin-loader" id="adminLoader">
        <img src="<?php echo e(asset('assets/img/simbole.png')); ?>" alt="Loading" class="admin-loader-logo" />
        <div class="admin-loader-bar">
            <div class="admin-loader-bar-fill"></div>
        </div>
        <p class="text-white/30 text-xs mt-4 tracking-widest uppercase">Carregando...</p>
    </div>

    
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    
    <aside id="sidebar" class="fixed left-0 top-0 h-full bg-navy z-50 sidebar-transition w-[250px] flex flex-col -translate-x-full lg:translate-x-0">
        
        <div class="h-16 flex items-center px-6 border-b border-navy-light/50">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(asset('assets/img/simbole.png')); ?>" alt="TSHOOT Logo" class="h-9 w-9 object-contain">
                <span class="sidebar-brand-text text-gold font-bold text-lg tracking-wide">TSHOOT CRM</span>
            </div>
        </div>

        
        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</span>
            </div>

            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <svg class="w-5 h-5 flex-shrink-0 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-gold' : ''); ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>
                </svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="<?php echo e(route('admin.contacts.index')); ?>"
               class="nav-link flex items-center justify-between px-6 py-3 text-gray-300 hover:text-white <?php echo e(request()->routeIs('admin.contacts.*') ? 'active' : ''); ?>">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 <?php echo e(request()->routeIs('admin.contacts.*') ? 'text-gold' : ''); ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="font-medium text-sm">Contactos</span>
                </div>
                <?php if(isset($newContacts) && $newContacts > 0): ?>
                    <span class="badge bg-gold text-navy text-xs font-bold px-2 py-0.5 rounded-full">
                        <?php echo e($newContacts); ?>

                    </span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('admin.visitors.index')); ?>"
               class="nav-link flex items-center justify-between px-6 py-3 text-gray-300 hover:text-white <?php echo e(request()->routeIs('admin.visitors.*') ? 'active' : ''); ?>">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 <?php echo e(request()->routeIs('admin.visitors.*') ? 'text-gold' : ''); ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium text-sm">Visitantes</span>
                </div>
                <?php if(isset($newVisitors) && $newVisitors > 0): ?>
                    <span class="badge bg-gold text-navy text-xs font-bold px-2 py-0.5 rounded-full">
                        <?php echo e($newVisitors); ?>

                    </span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('admin.images.index')); ?>"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white <?php echo e(request()->routeIs('admin.images.*') ? 'active' : ''); ?>">
                <svg class="w-5 h-5 flex-shrink-0 <?php echo e(request()->routeIs('admin.images.*') ? 'text-gold' : ''); ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium text-sm">Imagens</span>
            </a>

            <div class="px-4 my-3">
                <div class="border-t border-navy-light/50"></div>
            </div>

            <a href="<?php echo e(url('/')); ?>" target="_blank"
               class="nav-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span class="font-medium text-sm">Ver Site</span>
                <svg class="w-3.5 h-3.5 ml-auto text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </nav>

        
        <div class="border-t border-navy-light/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                    <span class="text-gold font-semibold text-sm">
                        <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate"><?php echo e(Auth::user()->name ?? 'Admin'); ?></p>
                    <p class="text-gray-400 text-xs truncate"><?php echo e(Auth::user()->email ?? 'admin@tshoot.co.ao'); ?></p>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors" title="Sair">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    
    <div class="lg:ml-[250px] min-h-screen flex flex-col">

        
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-navy transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                
                <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-navy transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>
                        </svg>
                    </a>
                    <?php if(isset($breadcrumbs) && count($breadcrumbs) > 0): ?>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span>/</span>
                            <?php if($loop->last): ?>
                                <span class="text-navy font-medium"><?php echo e($label); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="hover:text-navy transition-colors"><?php echo e($label); ?></a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center gap-3">
                
                <button class="relative p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <?php if(isset($unreadNotifications) && $unreadNotifications > 0): ?>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    <?php endif; ?>
                </button>

                
                <div class="hidden sm:flex items-center gap-3 pl-3 border-l border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-navy flex items-center justify-center">
                        <span class="text-white font-medium text-xs">
                            <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                        </span>
                    </div>
                    <span class="text-sm font-medium text-gray-700"><?php echo e(Auth::user()->name ?? 'Admin'); ?></span>
                </div>
            </div>
        </header>

        
        <div class="px-4 lg:px-6 pt-4 space-y-3">
            <?php if(session('success')): ?>
                <div class="fade-in flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1"><?php echo e(session('success')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="fade-in flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1"><?php echo e(session('error')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
                <div class="fade-in flex items-center gap-3 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1"><?php echo e(session('warning')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="fade-in flex items-center gap-3 p-4 bg-sky-50 border border-sky-200 text-sky-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium flex-1"><?php echo e(session('info')); ?></span>
                    <button onclick="this.parentElement.remove()" class="text-sky-500 hover:text-sky-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="fade-in flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-medium text-sm mb-1">Ocorreram os seguintes erros:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        
        <main class="flex-1 p-4 lg:p-6">
            
            <?php if(isset($pageTitle) || isset($pageActions)): ?>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-navy"><?php echo e($pageTitle ?? 'Dashboard'); ?></h1>
                        <?php if(isset($pageSubtitle)): ?>
                            <p class="text-sm text-gray-500 mt-1"><?php echo e($pageSubtitle); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if(isset($pageActions)): ?>
                        <div class="flex items-center gap-3">
                            <?php echo e($pageActions); ?>

                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        
        <footer class="border-t border-gray-200 bg-white">
            <div class="px-4 lg:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <p class="text-xs text-gray-500">
                    &copy; <?php echo e(date('Y')); ?> <span class="font-semibold text-navy">TSHOOT Soluções Tecnológicas</span>. Todos os direitos reservados.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    <a href="#" class="hover:text-navy transition-colors">Termos</a>
                    <a href="#" class="hover:text-navy transition-colors">Privacidade</a>
                    <span>v1.0.0</span>
                </div>
            </div>
        </footer>
    </div>

    
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

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\tshoot-angola\admin\resources\views/layouts/admin.blade.php ENDPATH**/ ?>