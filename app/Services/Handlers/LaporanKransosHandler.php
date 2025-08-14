<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;  

class LaporanKransosHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanKransos()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi' => $data['lokasi'] ?? "",
            'judul'=> $data['judul'] ?? "",
            'jenis_kransos' => $data['jenis_kransos'] ?? "",
            'deskripsi_kejadian' => $data['deskripsi_kejadian'] ?? "",
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? now(),
            'waktu_kejadian' => $data['waktu_kejadian'] ?? now()->format('H:i:s'),
            'status_penanganan'=> $data['status_penanganan'] ?? "menunggu",
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        
        $laporan->laporanKransos()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            [
            'judul'=> $data['judul'] ?? "",
            'jenis_kransos' => $data['jenis_kransos'] ?? "",
            'deskripsi_kejadian' => $data['deskripsi_kejadian'] ?? "",
            'tanggal_kejadian' => $data['tanggal_kejadian'] ?? now(),
            'waktu_kejadian' => $data['waktu_kejadian'] ?? now()->format('H:i:s'),
            'status_penanganan'=> $data['status_penanganan'] ?? "",
        ]);
        $this->handleUpdateCommonRelations($laporan, $data);
    }

    public function delete(Laporan $laporan): void
    {
        $laporan->laporanKransos()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
