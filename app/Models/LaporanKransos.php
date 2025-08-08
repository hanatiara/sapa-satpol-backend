<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKransos extends Model
{
    protected $table = 'laporan_kransos';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'jenis_kransos',
        'judul',
        'tanggal_kejadian',
        'waktu_kejadian',
        'status_penanganan',
        'deskripsi_kejadian'
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

}
