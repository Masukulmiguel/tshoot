<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM TSHOOT</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/simbole.png')); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#D4A11D',
                        'gold-light': '#E8C547',
                        navy: '#1B2A41',
                        'navy-dark': '#111D30',
                    },
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh;
            background: url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(17,29,48,0.92) 0%, rgba(27,42,65,0.88) 50%, rgba(212,161,29,0.1) 100%);
        }
        .grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        .card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .input-field {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #f1f5f9;
            transition: all 0.3s ease;
        }
        .input-field::placeholder { color: rgba(255,255,255,0.3); }
        .input-field:focus {
            outline: none;
            border-color: #D4A11D;
            box-shadow: 0 0 0 3px rgba(212,161,29,0.15);
            background: rgba(255,255,255,0.08);
        }
        .btn-gold {
            background: linear-gradient(135deg, #D4A11D, #b8910f);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212,161,29,0.3);
        }
        .btn-gold:active { transform: translateY(0); }
        .line-sep {
            width: 40px;
            height: 2px;
            background: #D4A11D;
        }
        .login-loader { position: fixed; inset: 0; background: #0f172a; z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease, visibility 0.5s ease; }
        .login-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .login-loader-logo { width: 100px; height: auto; animation: lPulse 1.5s ease-in-out infinite; }
        .login-loader-bar { width: 180px; height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px; margin-top: 2rem; overflow: hidden; }
        .login-loader-fill { height: 100%; background: #D4A11D; border-radius: 3px; animation: lFill 1.5s ease-in-out infinite; }
        @keyframes lPulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.05); opacity: 0.7; } }
        @keyframes lFill { 0% { width: 0%; margin-left: 0; } 50% { width: 100%; margin-left: 0; } 100% { width: 0%; margin-left: 100%; } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 relative z-10">

    <div class="login-loader" id="loginLoader">
        <img src="<?php echo e(asset('assets/img/simbole.png')); ?>" alt="Loading" class="login-loader-logo" />
        <div class="login-loader-bar">
            <div class="login-loader-fill"></div>
        </div>
        <p class="text-white/30 text-xs mt-4 tracking-widest uppercase">Carregando...</p>
    </div>

    <div class="grid-bg"></div>

    <div class="glow-orb" style="width:300px;height:300px;background:rgba(212,161,29,0.08);top:10%;left:15%;animation-delay:0s;"></div>
    <div class="glow-orb" style="width:250px;height:250px;background:rgba(59,130,246,0.05);bottom:15%;right:10%;animation-delay:7s;"></div>

    <div class="card rounded-2xl p-10 w-full max-w-sm relative">

        <div class="flex flex-col items-center">

            <div class="mb-5">
                <img src="<?php echo e(asset('assets/img/simbole.png')); ?>" alt="TSHOOT" class="h-14 w-14 object-contain mx-auto">
            </div>

            <h1 class="text-xl font-semibold text-white tracking-tight">TSHOOT</h1>
            <div class="line-sep my-3 mx-auto"></div>
            <p class="text-white/30 text-xs font-medium tracking-[0.2em] uppercase mb-7">CRM Admin</p>

            <?php if($errors->any()): ?>
                <div class="w-full mb-4 p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-xs">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="w-full" id="loginForm">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="block text-xs text-white/40 mb-1.5 font-medium">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        required
                        autofocus
                        class="input-field w-full px-4 py-3 rounded-xl text-sm"
                        placeholder="seu@email.com"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-xs text-white/40 mb-1.5 font-medium">Senha</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="input-field w-full px-4 py-3 pr-10 rounded-xl text-sm"
                            placeholder="••••••••"
                        >
                        <button type="button" onclick="togglePass()" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-white/60 transition">
                            <svg id="eye" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-gold w-full text-white font-medium py-3 rounded-xl text-sm">
                    <span id="txt">Entrar</span>
                    <svg id="spin" class="hidden animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            </form>

            <p class="mt-6 text-[10px] text-white/20">© 2026 Troubleshoot Soluções Tecnológicas</p>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loginLoader').classList.add('hidden');
            }, 1500);
        });
        function togglePass() {
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        }
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('txt').classList.add('hidden');
            document.getElementById('spin').classList.remove('hidden');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\tshoot-angola\admin\resources\views/auth/login.blade.php ENDPATH**/ ?>