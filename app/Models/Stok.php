<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok'; 

    protected $fillable = ['jenisPerubahan', 'jumlahPerubahan', 'tanggalBerubah', 'penjualan_id', 'panen_id'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function panen()
    {
        return $this->belongsTo(Panen::class);
    }
}


