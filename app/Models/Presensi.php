<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
     protected $table = 'presensis';

    protected $fillable=[
        'Username',
        'tanggal',
        'jam',
    ];

    public function user(){
        return $this->belongsTo(Login::class, 'Username', 'Username');
    }
}
