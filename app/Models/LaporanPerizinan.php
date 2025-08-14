<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPerizinan extends Model
{
    protected $table = 'laporan_perizinan';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'judul',
        'status_penanganan',
        'tanggal_kejadian',
        'waktu_kejadian',
        'nama_usaha',
        'jenis_perizinan',
        'deskripsi_kejadian',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

}
