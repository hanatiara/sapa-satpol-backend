<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanKransosHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanKransos()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi' => $data['lokasi'] ?? null,
            'jenis_kransos' => $data['jenis_kransos'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'jumlah_pelanggar' => $data['jumlah_pelanggar'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanKransos()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            ['lokasi' => $data['lokasi'] ?? null,
            'jenis_kransos' => $data['jenis_kransos'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'jumlah_pelanggar' => $data['jumlah_pelanggar'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }
}
