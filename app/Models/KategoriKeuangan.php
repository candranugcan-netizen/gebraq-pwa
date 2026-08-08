<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeuangan extends Model
{
    protected $fillable = ['nama_kategori'];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }
}
