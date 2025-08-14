<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiPos extends Model
{
    protected $table = "lokasi_pos";
    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'pos'
    ];

    public function laporan() {
        return $this->belongsTo(LaporanPiket::class, 'id_laporan', 'id_laporan');
    }
}
