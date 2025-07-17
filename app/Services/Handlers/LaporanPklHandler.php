<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanPklHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPkl()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi_pos' => $data['lokasi_pos'] ?? null,
            'jenis_pkl' => $data['jenis_pkl'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPkl()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            ['lokasi_pos' => $data['lokasi_pos'] ?? null,
            'jenis_pkl' => $data['jenis_pkl'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPkl()->delete();
    }
}
