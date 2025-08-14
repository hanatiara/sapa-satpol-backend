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
            'judul' => $data['judul'] ?? "",
            'status_penanganan' => $data['status_penanganan'] ?? "menunggu",
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? now(),
            'waktu_kejadian' => $data['waktu_kejadian'] ?? now()->format('H:i:s'),
            'nama_usaha' => $data['nama_usaha'] ?? "",
            'jenis_perizinan' => $data['jenis_perizinan'] ?? "",
            'deskripsi_kejadian'=> $data['deskripsi_kejadian'] ?? "",
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
            'deskripsi_kejadian'=> $data['deskripsi_kejadian'] ?? $laporan->laporanPerizinan->deskripsi_kejadian,
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPerizinan()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
