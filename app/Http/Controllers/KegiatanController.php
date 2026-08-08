<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->get();
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diterbitkan!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->foto) {
            Storage::disk('public')->delete($kegiatan->foto);
        }
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}
