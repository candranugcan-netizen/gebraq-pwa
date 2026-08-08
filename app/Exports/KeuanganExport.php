<?php

namespace App\Exports;

use App\Models\Keuangan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KeuanganExport implements FromQuery, WithHeadings, WithMapping
{
    protected $kategoriId;
    protected $tipe;

    public function __construct($kategoriId = null, $tipe = null)
    {
        $this->kategoriId = $kategoriId;
        $this->tipe = $tipe;
    }

    public function query()
    {
        $query = Keuangan::with('kategori')->latest('tanggal')->latest('id');

        if ($this->kategoriId) {
            $query->where('kategori_id', $this->kategoriId);
        }

        if ($this->tipe) {
            $query->where('tipe', $this->tipe);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kategori',
            'Keterangan',
            'Nominal (Rp)',
        ];
    }

    public function map($keuangan): array
    {
        return [
            $keuangan->tanggal,
            $keuangan->tipe,
            $keuangan->kategori->nama_kategori ?? '-',
            $keuangan->keterangan,
            $keuangan->nominal,
        ];
    }
}
