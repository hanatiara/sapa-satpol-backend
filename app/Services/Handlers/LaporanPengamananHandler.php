<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;

class LaporanPengamananHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPengamanan()->create([
            'id_laporan' => $laporan->id_laporan,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? "",
            'temuan' => $data['temuan'] ?? "",
            'status_kegiatan'=> $data['status_kegiatan'] ?? "Rencana",
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPengamanan()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            [
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? $laporan->laporanPengamanan->pelaksanaan_kegiatan,
            'temuan' => $data['temuan'] ?? $laporan->laporanPengamanan->temuan,
            'status_kegiatan'=> $data['status_kegiatan'] ?? $laporan->laporanPengamanan->status_kegiatan,
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPengamanan()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
