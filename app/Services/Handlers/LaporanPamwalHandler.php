<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;

class LaporanPamwalHandler implements LaporanHandlerInterface
{

    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPamwal()->create([
            'id_laporan' => $laporan->id_laporan,
            'kegiatan' => $data['kegiatan'] ?? "",
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? "",
            'temuan' => $data['temuan'] ?? "",
            'status_kegiatan' => "Rencana", 
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanPamwal()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            [
            'kegiatan' => $data['kegiatan'] ?? $laporan->laporanPamwal->kegiatan,
            'pelaksanaan_kegiatan' => $data['pelaksanaan_kegiatan'] ?? $laporan->laporanPamwal->pelaksanaan_kegiatan,
            'temuan' => $data['temuan'] ?? $laporan->laporanPamwal->temuan,
            'status_kegiatan' => $data['status_kegiatan'] ?? $laporan->laporanPamwal->status_kegiatan, 
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPamwal()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
