<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Gebraq - Gerakan Berantas Buta Huruf Al-Qur'an</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 pb-12">

    <!-- Header Mobile App Style -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-md mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xl">📖</span>
                <h1 class="font-bold text-xl text-indigo-600 tracking-tight">Gebraq.</h1>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-xs font-semibold bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-full border border-indigo-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold bg-indigo-600 text-white px-3.5 py-1.5 rounded-full shadow-sm hover:bg-indigo-700">Login Admin</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-md mx-auto px-4 pt-4 space-y-6">

        <!-- Banner Utama -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="relative z-10 space-y-3">
                <span class="inline-block bg-white/20 backdrop-blur-md text-xs font-semibold px-3 py-1 rounded-full">Program Gerakan</span>
                <h2 class="text-2xl font-black leading-snug">Berantas Buta Huruf Al-Qur'an</h2>
                <p class="text-xs text-indigo-100 leading-relaxed">Mewujudkan masyarakat bebas buta aksara Al-Qur'an melalui transparansi dan aksi nyata.</p>
                <div class="pt-2">
                    <a href="#kegiatan" class="inline-block bg-white text-indigo-700 font-bold text-xs px-4 py-2.5 rounded-xl shadow-md active:scale-95 transition">Lihat Dokumentasi ↓</a>
                </div>
            </div>
        </div>

        <!-- Kartu Ringkasan Keuangan (Transparansi) -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider px-1">Transparansi Kas</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm col-span-2">
                    <p class="text-xs font-medium text-slate-500">Saldo Kas Saat Ini</p>
                    <p class="text-2xl font-black text-indigo-600 mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
                <div class="bg-emerald-50/70 p-3.5 rounded-2xl border border-emerald-100">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase">Pemasukan</p>
                    <p class="text-sm font-extrabold text-emerald-700 mt-0.5">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-rose-50/70 p-3.5 rounded-2xl border border-rose-100">
                    <p class="text-[10px] font-bold text-rose-600 uppercase">Pengeluaran</p>
                    <p class="text-sm font-extrabold text-rose-700 mt-0.5">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Feed Kegiatan Terbaru -->
        <div id="kegiatan" class="space-y-3 pt-2">
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider px-1">Kegiatan Terbaru</h3>

            @forelse($kegiatan as $item)
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-28 bg-slate-100 flex items-center justify-center text-xs text-slate-400 font-medium">Tanpa Dokumentasi Foto</div>
                    @endif
                    <div class="p-4 space-y-1.5">
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </span>
                        <h4 class="font-bold text-base text-slate-800 leading-snug">{{ $item->judul }}</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 text-center rounded-2xl border border-slate-100">
                    <p class="text-xs text-slate-400">Belum ada kegiatan yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- Footer Mobile -->
    <footer class="max-w-md mx-auto px-4 mt-8 text-center text-xs text-slate-400 space-y-1">
        <p>© {{ date('Y') }} Program Gebraq PWA</p>
    </footer>

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
