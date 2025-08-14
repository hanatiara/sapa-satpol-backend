<?php

namespace App\Traits;

use App\Models\Waktu;
use App\Models\LokasiKegiatan;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;


trait HandlesCommonLaporanRelations
{
    public function handleCreateCommonRelations(Laporan $laporan, array $data)
    {
        // Handle dokumentasi (files from multipart/form-data)
        if (!empty($data['dokumentasi'])) {
            $dokumentasiItems = is_array($data['dokumentasi']) ? $data['dokumentasi'] : [$data['dokumentasi']];
        
            foreach ($dokumentasiItems as $dok) {
                if ($dok instanceof \Illuminate\Http\UploadedFile) {
                    $filename = $dok->hashName();
                    $dok->storeAs('dokumentasi', $filename, 'public');
        
                    Dokumentasi::create([
                        'id_laporan' => $laporan->id_laporan,
                        'url_dokumentasi' => 'storage/dokumentasi/'.$filename,
                    ]);
                } elseif (is_array($dok) && isset($dok['url_dokumentasi'])) {
                    Dokumentasi::create([
                        'id_laporan' => $laporan->id_laporan,
                        'url_dokumentasi' => $dok['url_dokumentasi'],
                    ]);
                }
            }
        }

        if (isset($data['personil'])) {
            $personil = json_decode($data['personil'], true);
            foreach ($personil ?? [] as $p) {
                DB::table('personil')->insert([
                    'id_laporan' => $laporan->id_laporan,
                    'id_nik'     => $p['id_nik'],
                    'absensi'    => $p['absensi'] ?? 'Hadir',
                ]);
            }
        }

        DB::table('lokasi_kegiatan')->insert([
            'id_laporan' => $laporan->id_laporan,
            'kecamatan'     => $data['kecamatan'] ?? "",
            'kelurahan'    => $data['kelurahan'] ?? "",
        ]);

        if (isset($data['waktu_mulai'])) {
            DB::table('waktu')->insert([
                'id_laporan' => $laporan->id_laporan,
                'waktu_mulai'     => $data['waktu_mulai'],
                'waktu_selesai'    => $data['waktu_selesai'],
            ]);
        }
        
    }

    public function handleUpdateCommonRelations(Laporan $laporan, array $data) {

        logger($data['dokumentasi']);
        
        DB::transaction(function () use ($laporan, $data) {
            $oldDocs = Dokumentasi::where('id_laporan', $laporan->id_laporan)->get();
        
            Dokumentasi::where('id_laporan', $laporan->id_laporan)->delete();
        
            foreach ($data['dokumentasi'] ?? [] as $dok) {
                if ($dok instanceof \Illuminate\Http\UploadedFile) {
                    $filename = $dok->hashName();
                    $dok->storeAs('dokumentasi', $filename, 'public');
                    Dokumentasi::create([
                        'id_laporan' => $laporan->id_laporan,
                        'url_dokumentasi' => 'storage/dokumentasi/' . $filename,
                    ]);
                } elseif (is_array($dok) && isset($dok['url_dokumentasi'])) {
                    Dokumentasi::create([
                        'id_laporan' => $laporan->id_laporan,
                        'url_dokumentasi' => $dok['url_dokumentasi'],
                    ]);
                }
            }

            foreach ($oldDocs as $old) {
                $path = str_replace('storage/', '', $old->url_dokumentasi);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        
            if(isset($data['personil'])) {
                DB::table('personil')->where('id_laporan', $laporan->id_laporan)->delete();

                // Insert new personil
                $personil = json_decode($data['personil'], true);
                foreach ($personil ?? [] as $p) {
                    DB::table('personil')->insert([
                        'id_laporan' => $laporan->id_laporan,
                        'id_nik' => $p['id_nik'],
                        'absensi' => $p['absensi'] ?? 'Hadir',
                    ]);
                }
            }

            if(isset($data['pelanggar'])) {
                // Delete existing pelanggar for this laporan
                DB::table('pelanggar')->where('id_laporan', $laporan->id_laporan)->delete();

                // Insert new pelanggar
                $pelanggar = json_decode($data['pelanggar'], true);
                foreach ($pelanggar ?? [] as $pel) {
                    DB::table('pelanggar')->insert([
                        'id_laporan' => $laporan->id_laporan,
                        'nama_pelanggar' => $pel['nama_pelanggar'] ?? null,
                    ]);
                }
            }
        });
        
        DB::table('lokasi_kegiatan')->UpdateOrInsert([
            'id_laporan' => $laporan->id_laporan,
            'kecamatan'     => $data['kecamatan'] ?? "",
            'kelurahan'    => $data['kelurahan'] ?? "",
        ]);

        if (isset($data['waktu_mulai'])) {
            DB::table('waktu')->UpdateOrInsert([
                'id_laporan' => $laporan->id_laporan,
                'waktu_mulai'     => $data['waktu_mulai'],
                'waktu_selesai'    => $data['waktu_mulai'],
            ]);
        }
        
    }

    public function handleDeleteCommonRelations(Laporan $laporan) {
        $dokumentasiList = Dokumentasi::where('id_laporan', $laporan->id_laporan)->get();

        static::deleting(function ($dok) {
            $filePath = str_replace('storage/', '', $dok->url_dokumentasi);
            Storage::disk('public')->delete($filePath);
        });

        Dokumentasi::where('id_laporan', $laporan->id_laporan)->delete();

        DB::table('personil')->where('id_laporan', $laporan->id_laporan)->delete();

        Waktu::where('id_laporan', $laporan->id_laporan)->delete();

        LokasiKegiatan::where('id_laporan', $laporan->id_laporan)->delete();
    }
}
