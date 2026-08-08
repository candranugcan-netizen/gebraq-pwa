<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-lg text-slate-800 leading-tight">Dashboard Admin</h2>
                <p class="text-xs text-slate-500">Selamat datang kembali, {{ Auth::user()->name }} 👋</p>
            </div>
            <a href="{{ route('landing') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1 text-xs text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg font-semibold hover:bg-indigo-100 transition">
                🌐 Lihat Web Publik
            </a>
        </div>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

        <!-- Card Utama: Saldo Kas -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-3xl p-5 text-white shadow-lg shadow-indigo-100">
            <p class="text-xs font-medium text-indigo-100">Total Saldo Kas Tersedia</p>
            <h3 class="text-3xl font-black mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            <div class="mt-4 pt-3 border-t border-white/10 flex justify-between items-center text-xs text-indigo-100">
                <span>Aktivitas Keuangan Aktif</span>
                <a href="{{ route('keuangan.index') }}" class="font-bold underline hover:text-white">Detail Keuangan →</a>
            </div>
        </div>

        <!-- Stats Ringkas Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm space-y-1">
                <p class="text-[10px] font-bold text-emerald-600 uppercase">Total Pemasukan</p>
                <p class="text-sm font-black text-slate-800">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm space-y-1">
                <p class="text-[10px] font-bold text-rose-600 uppercase">Total Pengeluaran</p>
                <p class="text-sm font-black text-slate-800">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm space-y-1 col-span-2 sm:col-span-1">
                <p class="text-[10px] font-bold text-indigo-600 uppercase">Dokumentasi</p>
                <p class="text-sm font-black text-slate-800">{{ $totalKegiatan }} Kegiatan Diterbitkan</p>
            </div>
        </div>

        <!-- Menu Akses Cepat (Quick Actions) -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Menu Pintas</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <a href="{{ route('keuangan.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-indigo-200 transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">💰</div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Catat Kas</p>
                        <p class="text-[10px] text-slate-400">Masuk/Keluar</p>
                    </div>
                </a>
                <a href="{{ route('kegiatan.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-indigo-200 transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">📸</div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Kegiatan</p>
                        <p class="text-[10px] text-slate-400">Post foto & berita</p>
                    </div>
                </a>
                <a href="{{ route('kategori.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-indigo-200 transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">🏷️</div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Kategori</p>
                        <p class="text-[10px] text-slate-400">Pos anggaran</p>
                    </div>
                </a>
                <a href="{{ route('landing') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-indigo-200 transition flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold text-lg">🌐</div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Web Publik</p>
                        <p class="text-[10px] text-slate-400">Lihat landing page</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Transaksi Terakhir -->
        <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm space-y-3">
            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">3 Transaksi Terakhir</h3>
                <a href="{{ route('keuangan.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentKeuangan as $item)
                    <div class="py-2.5 flex justify-between items-center text-xs">
                        <div>
                            <p class="font-bold text-slate-800">{{ $item->keterangan }}</p>
                            <p class="text-[10px] text-slate-400">{{ $item->tanggal }} • {{ $item->kategori->nama_kategori ?? '-' }}</p>
                        </div>
                        <span class="font-bold {{ $item->tipe == 'Pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $item->tipe == 'Pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-2">Belum ada transaksi dicatat.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
