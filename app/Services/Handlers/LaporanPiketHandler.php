<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanPiketHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPiket()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi_pos' => $data['lokasi_pos'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPiket()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            ['lokasi_pos' => $data['lokasi_pos'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPiket()->delete();
    }
}
