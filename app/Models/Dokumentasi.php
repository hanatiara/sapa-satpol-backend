<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = "dokumentasi";
    protected $primaryKey = "id_laporan";
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_laporan',
        'url_dokumentasi',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
