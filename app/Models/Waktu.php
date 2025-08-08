<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waktu extends Model
{
    protected $table = "waktu";
    protected $primaryKey = "id_laporan";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_laporan',
        'waktu_mulai',
        'waktu_selesai'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
