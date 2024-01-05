<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_pengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pengguna', 'email_pengguna', 'password_pengguna', 'username_pengguna', 'password_pengguna',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password_pengguna', 'remember_token',
    ];
}
