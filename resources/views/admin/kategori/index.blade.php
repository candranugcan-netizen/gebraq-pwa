<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-slate-800 leading-tight">Kelola Kategori</h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Form Tambah -->
        <div class="p-4 bg-white shadow-sm border border-slate-100 rounded-2xl">
            <h3 class="text-sm font-bold text-slate-700 mb-3">Tambah Kategori Baru</h3>
            <form action="{{ route('kategori.store') }}" method="POST" class="space-y-3">
                @csrf
                @if ($errors->any())
                    <div class="text-xs text-red-600 bg-red-50 p-3 rounded-xl">
                        @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                    </div>
                @endif
                <div class="flex gap-2">
                    <input type="text" name="nama_kategori" placeholder="Misal: Operasional, Donasi" class="text-sm border-slate-200 rounded-xl w-full focus:ring-indigo-500 focus:border-indigo-500" required>
                    <button type="submit" class="bg-indigo-600 text-white font-semibold text-sm px-4 py-2 rounded-xl hover:bg-indigo-700 active:scale-95 transition">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Daftar Kategori (Mobile Card Style) -->
        <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-700 border-b border-slate-100 pb-2">Daftar Kategori</h3>
            <div class="divide-y divide-slate-100">
                @forelse($kategori as $item)
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-800">🏷️ {{ $item->nama_kategori }}</span>
                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs text-red-500 hover:text-red-700 font-semibold bg-red-50 px-2.5 py-1 rounded-lg">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-2 text-center">Belum ada kategori disetup.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
