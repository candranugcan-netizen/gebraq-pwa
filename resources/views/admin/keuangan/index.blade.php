<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Transaksi Keuangan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah Transaksi -->
            <div class="p-6 bg-white shadow rounded-lg">
                <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-4">
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
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" class="border-gray-300 rounded-md w-full" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe</label>
                            <select name="tipe" class="border-gray-300 rounded-md w-full" required>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori_id" class="border-gray-300 rounded-md w-full" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nominal (Rp)</label>
                            <input type="number" name="nominal" placeholder="500000" class="border-gray-300 rounded-md w-full" required min="0">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <input type="text" name="keterangan" placeholder="Donasi dari Hamba Allah" class="border-gray-300 rounded-md w-full" required>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Catat Transaksi</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Transaksi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Tipe</th>
                            <th class="p-2">Kategori</th>
                            <th class="p-2">Keterangan</th>
                            <th class="p-2">Nominal</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keuangan as $item)
                        <tr class="border-b">
                            <td class="p-2">{{ $item->tanggal }}</td>
                            <td class="p-2 font-bold {{ $item->tipe == 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">{{ $item->tipe }}</td>
                            <td class="p-2">{{ $item->kategori->nama_kategori ?? 'Kategori Dihapus' }}</td>
                            <td class="p-2">{{ $item->keterangan }}</td>
                            <td class="p-2">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td class="p-2">
                                <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
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
