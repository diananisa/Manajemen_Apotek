<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'logins';
    protected $fillable=[
        'Username',
        'password',
    ];

    public function presensis(){
        return $this->hasMany(Presensi::class, 'Username', 'Username');
    }
}
