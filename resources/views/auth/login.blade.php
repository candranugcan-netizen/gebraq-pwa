<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Login Admin - Gebraq PWA</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm space-y-6">

        <!-- Header & Logo -->
        <div class="text-center space-y-2">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 font-black text-3xl text-indigo-600 tracking-tight">
                <span>📖</span> Gebraq.
            </a>
            <h2 class="text-lg font-bold text-slate-800">Login Portal Admin</h2>
            <p class="text-xs text-slate-500">Masuk untuk mengelola keuangan dan kegiatan</p>
        </div>

        <!-- Kartu Form Login -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-indigo-100/50 space-y-4">

            <!-- Notifikasi Status Sesi -->
            <x-auth-session-status class="mb-3 text-xs text-emerald-600 bg-emerald-50 p-2.5 rounded-xl border border-emerald-100" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="admin@gmail.com"
                        class="w-full text-sm border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full text-sm border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 p-3">
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-xs">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-slate-600 font-medium">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-indigo-600 hover:underline font-semibold" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 rounded-xl shadow-md shadow-indigo-200 active:scale-95 transition">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        <!-- Tautan Kembali -->
        <div class="text-center">
            <a href="{{ route('landing') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition inline-flex items-center gap-1">
                ← Kembali ke Web Publik
            </a>
        </div>

    </div>

    <!-- Service Worker Script -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
