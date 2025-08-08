<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;

class LaporanPiketHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        // dd($laporan->lokasi_pos);
        $laporan->laporanPiket()->create([
            'id_laporan' => $laporan->id_laporan,
            'lokasi_pos' => $data['lokasi_pos'] ?? null,
            'shift_piket' => $data['shift_piket'] ?? null,
            'kejadian' => $data['kejadian'] ?? null,
            'status_kegiatan'=> $data['status_kegiatan'] ?? null,
        ]);

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {

        $laporan->laporanPiket()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            ['
            lokasi_pos' => $data['lokasi_pos'] ?? $laporan->laporanPiket->lokasi_pos,
            'shift_piket' => $data['shift_piket'] ?? $laporan->laporanPiket->shift_piket,
            'kejadian' => $data['kejadian'] ?? $laporan->laporanPiket->kejadian,
            'status_kegiatan'=> $data['status_kegiatan'] ?? $laporan->laporanPiket->status_kegiatan,
        ]);

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPiket()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
