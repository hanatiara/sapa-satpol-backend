<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanReklame extends Model
{
    protected $table = 'laporan_reklame';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'nama_reklame',
        'jenis_reklame',
        'jenis_pelanggaran',
        'jumlah_reklame',
        'jenis_tindakan',
        'keterangan',
        'url_dokumentasi',
    ];

    public function laporan() {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }
}
