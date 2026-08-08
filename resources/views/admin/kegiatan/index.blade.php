<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Kegiatan Program Gebraq</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah Kegiatan -->
            <div class="p-6 bg-white shadow rounded-lg">
                <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded w-full">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Kegiatan</label>
                            <input type="text" name="judul" class="border-gray-300 rounded-md w-full" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal" class="border-gray-300 rounded-md w-full" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Kegiatan</label>
                        <textarea name="deskripsi" rows="3" class="border-gray-300 rounded-md w-full" required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto Dokumentasi (Maks. 2MB)</label>
                        <input type="file" name="foto" class="border-gray-300 rounded-md w-full accept="image/*"">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Terbitkan Kegiatan</button>
                </form>
            </div>

            <!-- Tabel Data Kegiatan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 w-20">Foto</th>
                            <th class="p-2">Judul</th>
                            <th class="p-2 whitespace-nowrap">Tanggal</th>
                            <th class="p-2">Deskripsi</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $item)
                        <tr class="border-b">
                            <td class="p-2">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" class="w-16 h-16 object-cover rounded shadow-sm">
                                @else
                                    <span class="text-xs text-gray-400 italic">Tanpa foto</span>
                                @endif
                            </td>
                            <td class="p-2 font-semibold">{{ $item->judul }}</td>
                            <td class="p-2 whitespace-nowrap">{{ $item->tanggal }}</td>
                            <td class="p-2">{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
                            <td class="p-2">
                                <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
