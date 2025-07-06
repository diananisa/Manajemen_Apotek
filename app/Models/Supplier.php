<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = '_supplier';

    use HasFactory;
    protected $fillable = [
        'Id_supplier',
        'Nama_Supplier',
        'Kontak',
        'Alamat',
        'Jenis_Barang_Obat',
        'Nama_PIC',
        'Status',
    ];
}
