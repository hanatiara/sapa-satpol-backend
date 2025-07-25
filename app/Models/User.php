<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

     protected $table = 'users';
     protected $primaryKey = 'id_nik';


     protected $fillable = [
        'id_nik',
        'nama',
        'alamat',
        'email',
        'password',
        'account_status',
        'account_role'
    ];

    protected $hidden = [
        'password',
    ];

}
