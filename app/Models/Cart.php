<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table= 'Carts';

    protected $fillable=[
        'Kode_Transaksi',
        'Tanggal_Transaksi',
        'Nama_Obat',
        'Jumlah',
        'Harga_Satuan',
        'Total_Harga',
    ];
    

}
