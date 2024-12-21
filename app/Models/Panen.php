<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    
    protected $table = 'panen'; 
    protected $fillable = [
        'jumlahPanen', 'tanggalPanen' 
    ];

    public function stok()
    {
        return $this->hasOne(Stok::class);
    }

    

}
