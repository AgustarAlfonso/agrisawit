<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    
    protected $table = 'panen'; 
    protected $fillable = [
        'jumlahPanen', 'tanggalPanen' 
    ];

    

}
