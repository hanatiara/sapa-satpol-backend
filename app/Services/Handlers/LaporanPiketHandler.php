<?php

namespace App\Services\Handlers;

use App\Models\Laporan;
use App\Models\LokasiPos;
use App\Services\LaporanHandlerInterface;
use App\Traits\HandlesCommonLaporanRelations;
use Illuminate\Support\Facades\DB;

class LaporanPiketHandler implements LaporanHandlerInterface
{
    use HandlesCommonLaporanRelations;
    public function create(Laporan $laporan, array $data)
    {
        $laporan->laporanPiket()->create([
            'id_laporan' => $laporan->id_laporan,
            'shift_piket' => $data['shift_piket'] ?? "",
            'kejadian' => $data['kejadian'] ?? "",
            'status_kegiatan'=> $data['status_kegiatan'] ?? "Rencana",
        ]);
        
        // Insert new lokasi_pos
        $lokasi_pos = json_decode($data['lokasi_pos'], true);
        if (!empty($lokasi_pos)) {
            foreach ($lokasi_pos as $pos) {
                LokasiPos::create([
                    'id_laporan' => $laporan->id_laporan,
                    'pos' => $pos['pos'] ?? null,
                ]);
            }
        }
    

        $this->handleCreateCommonRelations($laporan, $data);
    }

    public function update(Laporan $laporan, array $data)
    {

        $laporan->laporanPiket()->updateOrCreate([
            'id_laporan' => $laporan->id_laporan],
            [
            'shift_piket' => $data['shift_piket'] ?? $laporan->laporanPiket->shift_piket,
            'kejadian' => $data['kejadian'] ?? $laporan->laporanPiket->kejadian,
            'status_kegiatan'=> $data['status_kegiatan'] ?? $laporan->laporanPiket->status_kegiatan,
        ]);

        DB::transaction(function () use ($laporan, $data) {
            // Delete existing lokasi_pos for this laporan
            DB::table('lokasi_pos')->where('id_laporan', $laporan->id_laporan)->delete();
        
            // Insert new lokasi_pos
            $lokasi_pos = json_decode($data['lokasi_pos'], true);
            if (!empty($lokasi_pos)) {
                foreach ($lokasi_pos as $pos) {
                    LokasiPos::create([
                        'id_laporan' => $laporan->id_laporan,
                        'pos' => $pos['pos'] ?? null,
                    ]);
                }
            }
        });

        $this->handleUpdateCommonRelations($laporan, $data);
    }

     public function delete(Laporan $laporan): void
    {
        $laporan->laporanPiket()->delete();
        $this->handleDeleteCommonRelations($laporan);
    }
}
