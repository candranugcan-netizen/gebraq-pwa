<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangan = Keuangan::with('kategori')->latest()->get();
        $kategori = KategoriKeuangan::all();
        return view('admin.keuangan.index', compact('keuangan', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_keuangans,id',
            'tipe' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Keuangan::create($validated);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil dicatat!');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
