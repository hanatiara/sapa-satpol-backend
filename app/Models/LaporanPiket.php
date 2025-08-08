<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPiket extends Model
{
    protected $table = 'laporan_piket';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'lokasi_pos',
        'shift_piket',
        'kejadian',
        'status_kegiatan'
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
