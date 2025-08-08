<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;

class LaporanPklHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPkl()->create([
            'id_laporan' => $laporan->id_laporan,
            'judul' => $data['judul'] ?? null,
            'status_penanganan' => $data['status_penanganan'] ?? null,
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? null,
            'waktu_kejadian' => $data['waktu_kejadian'] ?? null,
            'jenis_pkl' => $data['jenis_pkl'] ?? null,
            'deskripsi_kejadian'=> $data['deskripsi_kejadian'] ?? null
        ]);
        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPkl()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            [
            'judul' => $data['judul'] ?? $laporan->laporanPkl->judul,
            'status_penanganan' => $data['status_penanganan'] ?? $laporan->laporanPkl->status_penanganan,
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? $laporan->laporanPkl->tanggal_kejadian,
            'waktu_kejadian' => $data['waktu_kejadian'] ?? $laporan->laporanPkl->waktu_kejadian,
            'jenis_pkl' => $data['jenis_pkl'] ?? $laporan->laporanPkl->jenis_pkl,
            'deskripsi_kejadian'=> $data['deskripsi_kejadian'] ?? $laporan->laporanPkl->deskripsi_kejadian
        ]);
        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPkl()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
