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
        'status_kehadiran',
        'role'
    ];

    public function user(){
        return $this->belongsTo(Login::class, 'Username', 'Username');
    }
}
