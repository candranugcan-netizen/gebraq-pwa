<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    public function index()
    {
        $kategori = KategoriKeuangan::latest()->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriKeuangan::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(KategoriKeuangan $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
