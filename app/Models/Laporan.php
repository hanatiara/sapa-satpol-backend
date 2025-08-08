<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'tanggal',
        'keterangan',
        'lokasi',        
        //
        'tindakan_lanjutan',
        'opd_pengampu',
        'urusan',
        'jumlah_pelanggar',
        'sumber_informasi',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function pelanggar()
    {
        return $this->hasMany(Pelanggar::class, 'id_laporan');
    }

    public function personil()
    {
        return $this->belongsToMany(User::class, 'personil', 'id_laporan', 'id_nik')
                    ->withPivot('absensi');
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'id_laporan');
    }

    public function waktu()
    {
        return $this->hasOne(Waktu::class, 'id_laporan');
    }

    public function lokasiKegiatan()
    {
        return $this->hasOne(LokasiKegiatan::class, 'id_laporan');
    }

    public function laporanKransos()
    {
        return $this->hasOne(LaporanKransos::class, 'id_laporan', 'id_laporan');
    }

    public function laporanPamwal()
    {
        return $this->hasOne(LaporanPamwal::class, 'id_laporan', 'id_laporan');
    }

    public function laporanPengamanan()
    {
        return $this->hasOne(LaporanPengamanan::class, 'id_laporan', 'id_laporan');
    }
    public function laporanPerizinan()
    {
        return $this->hasOne(LaporanPerizinan::class, 'id_laporan', 'id_laporan');
    }
    public function laporanPiket()
    {
        return $this->hasOne(LaporanPiket::class, 'id_laporan', 'id_laporan');
    }
    public function laporanPkl()
    {
        return $this->hasOne(LaporanPkl::class, 'id_laporan', 'id_laporan');
    }
    public function laporanReklame()
    {
        return $this->hasOne(LaporanReklame::class, 'id_laporan', 'id_laporan');
    }
}
