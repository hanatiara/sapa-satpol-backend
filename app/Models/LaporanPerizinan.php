<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPerizinan extends Model
{
    protected $table = 'laporan_perizinan';
    protected $primaryKey = 'id_laporan';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'lokasi',
        'nama',
        'jenis_perizinan',
        'jenis_pelanggaran',
        'jenis_tindakan',
        'jumlah',
        'url_dokumentasi',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
