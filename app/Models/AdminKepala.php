<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminKepala extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

     protected $table = 'admin_kepala';
     protected $primaryKey = 'id_nik';


     protected $fillable = [
        'id_nik',
        'nama_admin_kepala',
        'alamat',
        'email_admin',
        'jabatan',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
