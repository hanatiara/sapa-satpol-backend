<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPkl extends Model
{
    protected $table = 'laporan_pkl';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'judul',
        'status_penanganan',
        'tanggal_kejadian',
        'waktu_kejadian',
        'jenis_pkl',
        'deskripsi_kejadian',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

}
