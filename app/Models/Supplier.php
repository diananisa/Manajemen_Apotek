<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    use HasFactory;
    protected $fillabel = [
        'Id_supplier',
        'Nama_Produck',
        'Tanggal_Masuk',
        'Tanggal_Kadaluarsa',
        'Jumlah',
        'Total_Harga',
    ];
}
