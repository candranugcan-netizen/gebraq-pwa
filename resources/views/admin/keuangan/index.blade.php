<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-slate-800 leading-tight">Kelola Keuangan</h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
        <!-- Form Catat Transaksi Baru -->
        <div class="p-4 bg-white shadow-sm border border-slate-100 rounded-2xl">
            <h3 class="text-sm font-bold text-slate-700 mb-3">Catat Transaksi Baru</h3>
            <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-3">
                @csrf
                @if ($errors->any())
                    <div class="text-xs text-red-600 bg-red-50 p-3 rounded-xl">
                        @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="text-sm border-slate-200 rounded-xl w-full" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Tipe</label>
                        <select name="tipe" class="text-sm border-slate-200 rounded-xl w-full" required>
                            <option value="Pemasukan">Pemasukan (+)</option>
                            <option value="Pengeluaran">Pengeluaran (-)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Kategori</label>
                        <select name="kategori_id" class="text-sm border-slate-200 rounded-xl w-full" required>
                            <option value="" disabled selected>Pilih...</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Nominal (Rp)</label>
                        <input type="number" name="nominal" placeholder="100000" class="text-sm border-slate-200 rounded-xl w-full" required min="0">
                    </div>
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Keterangan</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Donasi Hamba Allah" class="text-sm border-slate-200 rounded-xl w-full" required>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white font-bold text-sm py-2.5 rounded-xl hover:bg-emerald-700 active:scale-95 transition">Simpan Transaksi</button>
            </form>
        </div>

        <!-- Header Filter & Tombol Ekspor (Icon di Mobile) -->
        <div class="p-4 bg-white shadow-sm border border-slate-100 rounded-2xl space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700">🔍 Filter Data</h3>

                <!-- Tombol Ekspor Excel & PDF -->
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('keuangan.export.excel', request()->query()) }}" title="Ekspor Excel" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 font-bold text-xs p-2 sm:px-3 sm:py-1.5 rounded-xl flex items-center gap-1.5 transition">
                        <span>📊</span>
                        <span class="hidden sm:inline">Excel</span>
                    </a>
                    <a href="{{ route('keuangan.export.pdf', request()->query()) }}" title="Ekspor PDF" class="bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 font-bold text-xs p-2 sm:px-3 sm:py-1.5 rounded-xl flex items-center gap-1.5 transition">
                        <span>📄</span>
                        <span class="hidden sm:inline">PDF</span>
                    </a>
                </div>
            </div>

            <form action="{{ route('keuangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <div>
                    <select name="kategori_id" class="text-xs border-slate-200 rounded-xl w-full">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="tipe" class="text-xs border-slate-200 rounded-xl w-full">
                        <option value="">-- Semua Tipe --</option>
                        <option value="Pemasukan" {{ request('tipe') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan (+)</option>
                        <option value="Pengeluaran" {{ request('tipe') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran (-)</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="w-full bg-indigo-600 text-white text-xs font-bold py-2 rounded-xl hover:bg-indigo-700 transition">Terapkan</button>
                    @if(request()->hasAny(['kategori_id', 'tipe']))
                        <a href="{{ route('keuangan.index') }}" class="bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-2 rounded-xl flex items-center justify-center hover:bg-slate-200 transition">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card Ringkasan Data Per Kategori -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Ringkasan Per Kategori</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @forelse($statKategori as $stat)
                    <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                            <span class="text-xs font-bold text-slate-800">🏷️ {{ $stat->nama_kategori }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600">
                                Saldo: Rp {{ number_format($stat->saldo, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div class="bg-emerald-50/70 p-2 rounded-xl border border-emerald-100">
                                <p class="text-[9px] font-bold text-emerald-600 uppercase">Pemasukan</p>
                                <p class="font-extrabold text-emerald-700 mt-0.5">Rp {{ number_format($stat->pemasukan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-rose-50/70 p-2 rounded-xl border border-rose-100">
                                <p class="text-[9px] font-bold text-rose-600 uppercase">Pengeluaran</p>
                                <p class="font-extrabold text-rose-700 mt-0.5">Rp {{ number_format($stat->pengeluaran, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center col-span-full">
                        <p class="text-xs text-slate-400">Belum ada kategori terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Daftar Transaksi (Mobile: Cards) -->
        <div class="space-y-2 sm:hidden">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Riwayat Transaksi</h3>
            @forelse($keuangan as $item)
                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm flex justify-between items-center">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $item->tipe == 'Pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ $item->tipe }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $item->tanggal }}</span>
                        </div>
                        <p class="text-sm font-bold text-slate-800">{{ $item->keterangan }}</p>
                        <p class="text-xs text-slate-500">🏷️ {{ $item->kategori->nama_kategori ?? '-' }}</p>
                    </div>
                    <div class="text-right space-y-1">
                        <p class="text-sm font-black {{ $item->tipe == 'Pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $item->tipe == 'Pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </p>
                        <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[10px] text-red-500 font-semibold underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-4 bg-white rounded-2xl">Belum ada transaksi sesuai filter.</p>
            @endforelse

            <div class="pt-2">
                {{ $keuangan->links() }}
            </div>
        </div>

        <!-- Daftar Transaksi (Desktop: Table) -->
        <div class="hidden sm:block bg-white border border-slate-100 rounded-2xl p-4 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Riwayat Transaksi</h3>
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b text-slate-400 font-medium text-xs">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Tipe</th>
                        <th class="p-2">Kategori</th>
                        <th class="p-2">Keterangan</th>
                        <th class="p-2">Nominal</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($keuangan as $item)
                    <tr>
                        <td class="p-2 text-slate-500">{{ $item->tanggal }}</td>
                        <td class="p-2 font-bold {{ $item->tipe == 'Pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $item->tipe }}</td>
                        <td class="p-2 text-slate-700">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td class="p-2 text-slate-800 font-medium">{{ $item->keterangan }}</td>
                        <td class="p-2 font-bold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="p-2">
                            <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-xs text-slate-400">Belum ada transaksi sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pt-2">
                {{ $keuangan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
