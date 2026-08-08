<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use App\Exports\KeuanganExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk dropdown filter & form
        $kategori = KategoriKeuangan::all();

        // 2. Query dasar Keuangan dengan Filter
        $query = Keuangan::with('kategori')->latest('tanggal')->latest('id');

        // Filter berdasarkan Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan Tipe (Pemasukan / Pengeluaran)
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Paginasi 10 data per halaman + withQueryString agar filter tidak lepas saat klik Next/Prev
        $keuangan = $query->paginate(10)->withQueryString();

        // 3. Hitung Ringkasan Data (Pemasukan, Pengeluaran, Saldo) per Kategori
        $statKategori = $kategori->map(function ($kat) {
            $pemasukan = Keuangan::where('kategori_id', $kat->id)->where('tipe', 'Pemasukan')->sum('nominal');
            $pengeluaran = Keuangan::where('kategori_id', $kat->id)->where('tipe', 'Pengeluaran')->sum('nominal');
            $saldo = $pemasukan - $pengeluaran;

            return (object)[
                'id' => $kat->id,
                'nama_kategori' => $kat->nama_kategori,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $saldo,
            ];
        });

        // Jika user memilih filter kategori tertentu, fokuskan tampilan card ke kategori tersebut
        if ($request->filled('kategori_id')) {
            $statKategori = $statKategori->where('id', $request->kategori_id);
        }

        return view('admin.keuangan.index', compact('keuangan', 'kategori', 'statKategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:Pemasukan,Pengeluaran',
            'kategori_id' => 'required',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
        ]);

        Keuangan::create($request->all());

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }

    public function destroy($id)
    {
        $data = Keuangan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

    // Fitur Ekspor Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new KeuanganExport($request->kategori_id, $request->tipe),
            'Laporan_Keuangan_Gebraq_' . date('Ymd_His') . '.xlsx'
        );
    }

    // Fitur Ekspor PDF
    public function exportPdf(Request $request)
    {
        $query = Keuangan::with('kategori')->latest('tanggal')->latest('id');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $keuangan = $query->get();

        $pemasukan = $keuangan->where('tipe', 'Pemasukan')->sum('nominal');
        $pengeluaran = $keuangan->where('tipe', 'Pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        $pdf = Pdf::loadView('admin.keuangan.pdf', compact('keuangan', 'pemasukan', 'pengeluaran', 'saldo'));

        return $pdf->download('Laporan_Keuangan_Gebraq_' . date('Ymd_His') . '.pdf');
    }
}
