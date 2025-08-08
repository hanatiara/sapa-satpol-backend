<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;
class LaporanPerizinanHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPerizinan()->create([
            'id_laporan' => $laporan->id_laporan,
            'judul' => $data['judul'] ?? null,
            'status_penanganan' => $data['status_penanganan'] ?? null,
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? null,
            'waktu_kejadian' => $data['waktu_kejadian'] ?? null,
            'nama_usaha' => $data['nama_usaha'] ?? null,
            'jenis_perizinan' => $data['jenis_perizinan'] ?? null,
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPerizinan()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            [
            'judul' => $data['judul'] ?? $laporan->laporanPerizinan->judul,
            'status_penanganan' => $data['status_penanganan'] ?? $laporan->laporanPerizinan->status_penanganan,
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? $laporan->laporanPerizinan->tanggal_kejadian,
            'waktu_kejadian' => $data['waktu_kejadian'] ?? $laporan->laporanPerizinan->waktu_kejadian,
            'nama_usaha' => $data['nama_usaha'] ?? $laporan->laporanPerizinan->nama_usaha,
            'jenis_perizinan' => $data['jenis_perizinan'] ?? $laporan->laporanPerizinan->jenis_perizinan,
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPerizinan()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
