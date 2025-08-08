<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiKegiatan extends Model
{
    protected $table = "lokasi_kegiatan";
    protected $primaryKey = "id_laporan";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_laporan',
        'kecamatan',
        'kelurahan'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
