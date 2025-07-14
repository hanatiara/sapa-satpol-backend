<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Masyarakat extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

     protected $table = 'masyarakats';
     protected $primaryKey = 'id_nik';


     protected $fillable = [
        'id_nik',
        'nama_masyarakat',
        'alamat',
        'email_masyarakat',
        'password',
        'account_status',
    ];

    protected $hidden = [
        'password',
    ];

}
