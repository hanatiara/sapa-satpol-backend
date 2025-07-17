<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanPamwalHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPamwal()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi' => $data['lokasi'] ?? null,
            'kegiatan' => $data['kegiatan'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi'=> $data['url_dokumentasi'] ?? null
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPamwal()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            ['lokasi' => $data['lokasi'] ?? null,
            'kegiatan' => $data['kegiatan'] ?? null,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? null,
            'temuan' => $data['temuan'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi'=> $data['url_dokumentasi'] ?? null
        ]);
    }
}
