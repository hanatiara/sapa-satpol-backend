<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggar extends Model
{
    protected $table = "pelanggar";
    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'nama_pelanggar'
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
