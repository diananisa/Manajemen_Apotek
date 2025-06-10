<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Stoct_produk';
    
    protected $fillabel = [
        'Nama_Product',
        'Tanggal_kadaluarsa',
        'Stock',
        'Harga',

    ];
}
