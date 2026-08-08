<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Mengambil 3 kegiatan terbaru untuk ditunjukkan di landing page
        $kegiatan = Kegiatan::latest()->take(3)->get();

        // Menghitung akumulasi pemasukan, pengeluaran, dan sisa saldo
        $pemasukan = Keuangan::where('tipe', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('tipe', 'Pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        return view('welcome', compact('kegiatan', 'pemasukan', 'pengeluaran', 'saldo'));
    }
}
