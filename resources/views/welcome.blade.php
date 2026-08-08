<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <title>Gebraq - Gerakan Berantas Buta Huruf Al-Qur'an</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">Gebraq.</h1>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline font-semibold">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline font-semibold">Login Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-indigo-600 text-white py-20 text-center px-4">
        <h2 class="text-4xl font-extrabold mb-4">Gerakan Berantas Buta Huruf Al-Qur'an</h2>
        <p class="text-lg max-w-2xl mx-auto mb-8">Membangun generasi Qur'ani melalui pendidikan, pembagian Al-Qur'an, dan dukungan operasional pengajar di seluruh pelosok desa.</p>
        <a href="#kegiatan" class="bg-white text-indigo-600 font-bold py-3 px-6 rounded-full shadow-lg hover:bg-gray-100 transition">Lihat Kegiatan Kami</a>
    </div>

    <!-- Transparansi Keuangan -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
        <div class="bg-white rounded-lg shadow-xl p-6 md:p-10">
            <h3 class="text-2xl font-bold text-center mb-6">Transparansi Dana</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                    <p class="text-sm text-green-600 font-bold uppercase">Total Pemasukan</p>
                    <p class="text-3xl font-extrabold text-green-700 mt-2">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-50 p-6 rounded-lg border border-red-100">
                    <p class="text-sm text-red-600 font-bold uppercase">Total Pengeluaran</p>
                    <p class="text-3xl font-extrabold text-red-700 mt-2">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                    <p class="text-sm text-indigo-600 font-bold uppercase">Saldo Saat Ini</p>
                    <p class="text-3xl font-extrabold text-indigo-700 mt-2">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kegiatan Terbaru -->
    <div id="kegiatan" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-center mb-12">Kegiatan Terbaru</h3>

            @if($kegiatan->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($kegiatan as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">Tanpa Foto</div>
                        @endif
                        <div class="p-6">
                            <p class="text-sm text-indigo-600 font-semibold mb-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                            <h4 class="text-xl font-bold mb-2">{{ $item->judul }}</h4>
                            <p class="text-gray-600 text-sm">{{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada kegiatan yang dipublikasikan.</p>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-8">
        <p>&copy; {{ date('Y') }} Program Gebraq. Hak cipta dilindungi.</p>
    </footer>

    <!-- PWA Service Worker Registration -->
            <script>
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', () => {
                        navigator.serviceWorker.register('/sw.js')
                            .then((reg) => console.log('Service Worker Registered!', reg))
                            .catch((err) => console.log('Service Worker Failed!', err));
                    });
                }
            </script>
</body>
</html>
