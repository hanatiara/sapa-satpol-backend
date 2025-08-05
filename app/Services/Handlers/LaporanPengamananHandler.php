<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanPengamananHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPengamanan()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi' => $data['lokasi'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'tindakan' => $data['tindakan'] ?? null,
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPengamanan()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            ['lokasi' => $data['lokasi'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'tindakan' => $data['tindakan'] ?? null,
        ]);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPengamanan()->delete();
    }
}
