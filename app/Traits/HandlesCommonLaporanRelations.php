<?php

namespace App\Traits;

use App\Models\Waktu;
use App\Models\LokasiKegiatan;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use Illuminate\Support\Facades\Log;

trait HandlesCommonLaporanRelations
{
    public function handleCreateCommonRelations(Laporan $laporan, array $data)
    {
        foreach ($data['dokumentasi'] ?? [] as $dok) {
            Dokumentasi::create([
                'id_laporan' => $laporan->id_laporan,
                'url_dokumentasi' => $dok['url_dokumentasi'],
            ]);
        }

        foreach ($data['personil'] ?? [] as $p) {
            DB::table('personil')->insert([
                'id_laporan' => $laporan->id_laporan,
                'id_nik' => $p['id_nik'],
                'absensi' => $p['absensi'] ?? 'Hadir',
            ]);
        }
    }

    public function handleUpdateCommonRelations(Laporan $laporan, array $data) {
        // dd($data['waktu_kejadian'][0]);
        if (isset($data['waktu'][0])) {
            Waktu::updateOrCreate(
                ['id_laporan' => $laporan->id_laporan],
                [
                    'waktu_mulai' => $data['waktu'][0]['waktu_mulai'] ?? null,
                    'waktu_selesai' => $data['waktu'][0]['waktu_selesai'] ?? null,
                ]
            );
        }

        if (isset($data['lokasi_kegiatan'][0])) {
            LokasiKegiatan::updateOrCreate(
                ['id_laporan' => $laporan->id_laporan],
                [
                    'kecamatan' => $data['lokasi_kegiatan'][0]['kecamatan'] ?? null,
                    'kelurahan' => $data['lokasi_kegiatan'][0]['kelurahan'] ?? null,
                ]
            );
        }
        foreach ($data['personil'] ?? [] as $p) {
            DB::table('personil')->updateOrInsert(
                [
                    'id_laporan' => $laporan->id_laporan,
                    'id_nik' => $p['id_nik'],
                ],
                [
                    'absensi' => $p['absensi'] ?? 'Hadir',
                ]
            );
        }
        foreach ($data['pelanggar'] ?? [] as $p) {
            DB::table('pelanggar')->updateOrInsert(
                [
                    'id_laporan' => $laporan->id_laporan,
                ],
                [
                    'nama_pelanggar' => $p['nama_pelanggar'] ?? null,
                ]
            );
        }
        
    }

    public function handleDeleteCommonRelations(Laporan $laporan) {
        Dokumentasi::where('id_laporan', $laporan->id_laporan)->delete();

        DB::table('personil')->where('id_laporan', $laporan->id_laporan)->delete();

        Waktu::where('id_laporan', $laporan->id_laporan)->delete();

        LokasiKegiatan::where('id_laporan', $laporan->id_laporan)->delete();
    }
}
