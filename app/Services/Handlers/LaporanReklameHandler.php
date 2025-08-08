<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;

class LaporanReklameHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanReklame()->create([
            'id_laporan' => $laporan->id_laporan,
            'status_kegiatan' => $data['status_kegiatan'] ?? null,
            'jenis_reklame' => $data['jenis_reklame'] ?? null,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? null,
            'jumlah_reklame' => $data['jumlah_reklame'] ?? null,
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {
        $laporan->laporanReklame()->updateOrCreate(
            ['id_laporan' => $laporan->id_laporan],
            ['status_kegiatan' => $data['status_kegiatan'] ?? $laporan->laporanReklame->status_kegiatan,
            'jenis_reklame' => $data['jenis_reklame'] ?? $laporan->laporanReklame->jenis_reklame,
            'jenis_pelanggaran' => $data['jenis_pelanggaran'] ?? $laporan->laporanReklame->jenis_pelanggaran,
            'jumlah_reklame' => $data['jumlah_reklame'] ?? $laporan->laporanReklame->jumlah_reklame,
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

    public function delete(Laporan $laporan): void
    {
        $laporan->laporanReklame()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }

}
