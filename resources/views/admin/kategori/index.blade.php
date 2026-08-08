<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Kategori Keuangan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah -->
            <div class="p-6 bg-white shadow rounded-lg">
                <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
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

                    <div class="flex gap-4">
                        <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru" class="border-gray-300 rounded-md w-full" required>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 w-16">No</th>
                            <th class="p-2">Nama Kategori</th>
                            <th class="p-2 w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $item)
                        <tr class="border-b">
                            <td class="p-2">{{ $index + 1 }}</td>
                            <td class="p-2">{{ $item->nama_kategori }}</td>
                            <td class="p-2">
                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Data keuangan terkait mungkin akan ikut terhapus.')">
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
