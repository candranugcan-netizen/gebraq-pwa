<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = ['kategori_id', 'tipe', 'nominal', 'keterangan', 'tanggal'];

    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }
}
