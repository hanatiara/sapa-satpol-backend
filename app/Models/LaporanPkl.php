<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPkl extends Model
{
    protected $table = 'laporan_pkl';
    protected $primaryKey = 'id_laporan';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'jenis_pkl',
        'jenis_pelanggaran',
        'jenis_tindakan',
        'keterangan',
        'url_dokumentasi',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
