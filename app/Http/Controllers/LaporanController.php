<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\LaporanHandlerResolver;
use App\Traits\HandlesCommonLaporanRelations;
use App\Models\User;

class LaporanController extends Controller
{
    protected array $relationMap = [
        'kransos' => 'laporanKransos',
        'pamwal' => 'laporanPamwal',
        'pengamanan' => 'laporanPengamanan',
        'perizinan' => 'laporanPerizinan',
        'piket' => 'laporanPiket',
        'pkl' => 'laporanPkl',
        'reklame' => 'laporanReklame',
    ];

    public function showAllLaporan() {
        $laporan = Laporan::with([
            'personil',
            'dokumentasi',
            'waktu',
            'lokasiKegiatan',
            'pelanggar',
            ...array_values($this->relationMap)
        ])->get();
    
        return response()->json([
            'message' => 'Semua laporan berhasil diambil',
            'total' => $laporan->count(),
            'data' => $laporan,
        ]);
    }

    public function showToday() {
        $relations = array_values($this->relationMap);
        $today = Carbon::today();

        $laporan = Laporan::with($relations)->whereDate('tanggal', $today)->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'total' => $laporan->count(),
            'laporan' => $laporan,
        ], 200);

    }

    public function showLaporanById (Request $request) {
        $laporan = Laporan::with([
            'personil',
            'dokumentasi',
            'waktu',
            'lokasiKegiatan',
            'pelanggar',
            ...array_values($this->relationMap)
        ])->find($request->id_laporan);

        if(!$laporan) {
            return response()->json(['message' => 'Laporan not found'], 404);
        }

        return response()->json([
            'data' => $laporan,
        ]);
    }

    public function updateLaporan(Request $request, LaporanHandlerResolver $resolver) {
        $id_laporan = $request->id_laporan;

        $laporan = Laporan::findOrFail($id_laporan);

        $type = $request->type;

        $laporan->update([
            'tanggal' => $request->tanggal ?? $laporan->tanggal,
            'opd_pengampu' => $request->opd_pengampu ?? $laporan->opd_pengampu,
            'urusan' => $request->urusan ?? $laporan->urusan,
            'jumlah_pelanggar' => $request->jumlah_pelanggar ?? $laporan->jumlah_pelanggar,
            'sumber_informasi' => $request->sumber_informasi ?? $laporan->sumber_informasi,
            'lokasi' =>$request->lokasi ?? $laporan->lokasi,
            'tindakan_lanjutan'=>$request->tindakan_lanjutan ?? $laporan->tindakan_lanjutan,
        ]);

        $handler = $resolver->resolveByType($type);
        $handler->update($laporan, $request->all());

        $relations = $this->relationMap[$type] ?? null;

        return response()->json([
            'message' => 'Laporan berhasil diperbarui',
            'data' => $laporan->load([
                $relations,         
                'personil',         
                'dokumentasi',     
                'waktu',           
                'lokasiKegiatan', 
                'pelanggar'         
            ]),  
        ]);
    }

    public function createLaporan(Request $request, LaporanHandlerResolver $resolver) {
        $id_laporan = Str::uuid();
        // dd($request->lokasi_pos);

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'tanggal' => $request->tanggal,
            'type' => $request->type,
            'keterangan' => $request->keterangan,
            'tindakan_lanjutan' => $request->tindakan_lanjutan,
            'lokasi' => $request->lokasi
        ]);

        $handler = $resolver->resolveByType($request->type);
        $handler->create($laporan, $request->all());

        $relations = $this->relationMap[$request->type] ?? null;

        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan->load([
                $relations,         
                'personil',         
                'dokumentasi',     
                'waktu',           
                'lokasiKegiatan',
                'pelanggar'          
            ]),  
        ], 201);

    }


    public function deleteLaporan(Request $request, LaporanHandlerResolver $resolver) {
        $laporan = Laporan::find($request->id_laporan);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan not found'], 404);
        }

        $type = null;

        foreach ($this->relationMap as $key => $relation) {
            if ($laporan->$relation()->exists()) {
                $type = $key;
                break;
            }
        }

        if (!$type) {
            return response()->json(['message' => 'Unable to determine laporan type'], 400);
        }

        $handler = $resolver->resolveByType($type);
        $handler->delete($laporan);
        $laporan->delete();
        return response()->json(['message' => 'Laporan deleted successfully'], 200);
        }

    public function showPersonil(Request $request) {

    }

}

