<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPamwal extends Model
{
    protected $table = 'laporan_pamwal';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'lokasi',
        'kegiatan',
        'pelaksanaan_kegiatan',
        'temuan',
        'jenis_tindakan',
        'keterangan',
        'url_dokumentasi',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
