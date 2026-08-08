<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-slate-800 leading-tight">Kelola Kegiatan</h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Form Publish Kegiatan -->
        <div class="p-4 bg-white shadow-sm border border-slate-100 rounded-2xl">
            <h3 class="text-sm font-bold text-slate-700 mb-3">Terbitkan Kegiatan Baru</h3>
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @if ($errors->any())
                    <div class="text-xs text-red-600 bg-red-50 p-3 rounded-xl">
                        @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Judul Kegiatan</label>
                        <input type="text" name="judul" class="text-sm border-slate-200 rounded-xl w-full" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="text-sm border-slate-200 rounded-xl w-full" required>
                    </div>
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Deskripsi Ringkas</label>
                    <textarea name="deskripsi" rows="2" class="text-sm border-slate-200 rounded-xl w-full" required></textarea>
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-500 uppercase">Foto Dokumentasi (Opsional, Maks 2MB)</label>
                    <input type="file" name="foto" accept="image/*" class="text-xs border-slate-200 rounded-xl w-full p-2">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold text-sm py-2.5 rounded-xl hover:bg-indigo-700 active:scale-95 transition">Publikasikan Kegiatan</button>
            </form>
        </div>

        <!-- Cards List Kegiatan -->
        <div class="space-y-3">
            <h3 class="text-sm font-bold text-slate-700 px-1">Daftar Kegiatan Diterbitkan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @forelse($kegiatan as $item)
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-20 bg-slate-100 flex items-center justify-center text-xs text-slate-400">Tanpa Foto</div>
                            @endif
                            <div class="p-3 space-y-1">
                                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $item->tanggal }}</span>
                                <h4 class="font-bold text-sm text-slate-800 leading-snug">{{ $item->judul }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="p-3 pt-0 text-right">
                            <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-500 font-semibold bg-red-50 px-3 py-1 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4 bg-white rounded-2xl col-span-full">Belum ada kegiatan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
