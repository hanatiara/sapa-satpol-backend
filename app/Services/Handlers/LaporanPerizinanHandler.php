<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;

class LaporanPerizinanHandler implements LaporanHandlerInterface
{
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPerizinan()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi' => $data['lokasi'] ?? null,
            'nama' => $data['nama'] ?? null,
            'jenis_perizinan' => $data['jenis_perizinan'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'jumlah' => $data['jumlah'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPerizinan()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            ['lokasi' => $data['lokasi'] ?? null,
            'nama' => $data['nama'] ?? null,
            'jenis_perizinan' => $data['jenis_perizinan'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jenis_tindakan' => $data['jenis_tindakan'] ?? null,
            'jumlah' => $data['jumlah'] ?? null,
            'url_dokumentasi' => $data['url_dokumentasi'] ?? null,
        ]);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPerizinan()->delete();
    }
}
