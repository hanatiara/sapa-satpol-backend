<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengamanan extends Model
{
    protected $table = 'laporan_pengamanan';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'pelaksanaan_kegiatan',
        'temuan',
        'status_kegiatan'
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

}
