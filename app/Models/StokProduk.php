<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    protected $table = '_stock__produk';

    protected $primaryKey = 'ID_Produk';

    public $timestamps = false;
}
