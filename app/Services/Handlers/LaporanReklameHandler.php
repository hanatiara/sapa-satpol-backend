<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanReklameHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanReklame()->create([
            'id_laporan' => $laporan->id_laporan,
            'nama_reklame' => $data['nama_reklame'] ?? null,
            'jenis_reklame' => $data['jenis_reklame'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jumlah_reklame' => $data['jumlah_reklame'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);


    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanReklame()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            ['nama_reklame' => $data['nama_reklame'] ?? null,
            'jenis_reklame' => $data['jenis_reklame'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jumlah_reklame' => $data['jumlah_reklame'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'keterangan' => $data['keterangan'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);


    }


}
