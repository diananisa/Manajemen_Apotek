<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = '_stock__produk';
    use HasFactory;
    protected $fillable = [
        'gambar',
        'Id_Obat',
        'Nama_Obat',
        'Tanggal_Kadaluarsa',
        'supplier_id',
        'Harga_Jual',
        'Jenis_Satuan',
        'Jumlah',
        'Total_Harga',
    ];

    // Relasi ke tabel Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
