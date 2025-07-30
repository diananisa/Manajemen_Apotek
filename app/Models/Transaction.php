<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'Kode_Transaksi',
        'Tanggal_Transaksi',
        'Total',
        'Metode_Pembelian',
    ];
}
