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
use Illuminate\Support\Facades\DB;

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
            'assignedUsers',
            'personil',
            'dokumentasi',
            'waktu',
            'lokasiKegiatan',
            'pelanggar',
            ...array_values($this->relationMap)
        ])
        ->when(in_array('piket', array_keys($this->relationMap)), function ($query) {
            $query->with('laporanPiket.lokasiPos');
         })
         ->whereHas('assignedUsers', function ($query) {
            $query->whereIn('account_role', ['admin_pelaporan']);
        })
         ->get();
    
        return response()->json([
            'message' => 'Semua laporan berhasil diambil',
            'total' => $laporan->count(),
            'data' => $laporan,
        ]);
    }

    public function showAllLaporanPelanggaran() {
        $laporan = Laporan::with([
            'assignedUsers',
            'personil',
            'dokumentasi',
            'waktu',
            'lokasiKegiatan',
            'pelanggar',
            ...array_values($this->relationMap)
        ])
        ->when(in_array('piket', array_keys($this->relationMap)), function ($query) {
            $query->with('laporanPiket.lokasiPos');
        
        })
        ->whereHas('assignedUsers', function ($query) {
            $query->whereIn('account_role', ['masyarakat', 'admin_masyarakat']);
        })
        ->get();
    
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
            'assignedUsers',
            'personil',
            'dokumentasi',
            'waktu',
            'lokasiKegiatan',
            'pelanggar',
            ...array_values($this->relationMap)
        ])
        ->when(in_array('piket', array_keys($this->relationMap)), function ($query) {
            $query->with('laporanPiket.lokasiPos');
        })
        ->find($request->id_laporan);

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
            'tanggal' => $request->tanggal ?? now(),
            'opd_pengampu' => $request->opd_pengampu ?? "",
            'urusan' => $request->urusan ?? "",
            'jumlah_pelanggar' => $request->jumlah_pelanggar ?? 0,
            'sumber_informasi' => $request->sumber_informasi ?? "",
            'lokasi' =>$request->lokasi ?? "",
            'tindakan_lanjutan'=>$request->tindakan_lanjutan ?? "",
        ]);

        $handler = $resolver->resolveByType($type);
        $handler->update($laporan, $request->all());

        $relations = $this->relationMap[$type] ?? null;

        $relationsToLoad = array_merge(
            (array) $relations,
            [
                'assignedUsers',
                'personil',
                'dokumentasi',
                'waktu',
                'lokasiKegiatan',
                'pelanggar'
            ]
        );
        
        if ($laporan->laporanPiket()->exists()) {
            $relationsToLoad[] = 'laporanPiket.lokasiPos';
        }
        
        return response()->json([
            'message' => 'Laporan berhasil diperbarui',
            'data' => $laporan->load($relationsToLoad),
        ]);
    }

    public function createLaporan(Request $request, LaporanHandlerResolver $resolver) {
        // dd($request->all());
        $id_laporan = Str::uuid();

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'id_nik' => $request->id_nik,
            'tanggal' => $request->tanggal,
            'type' => $request->type,
            'keterangan' => $request->keterangan,
            'tindakan_lanjutan' => $request->tindakan_lanjutan ?? "",
            'lokasi' => $request->lokasi
        ]);

        $handler = $resolver->resolveByType($request->type);
        $handler->create($laporan, $request->all());

        $relations = $this->relationMap[$request->type] ?? null;

        $relationsToLoad = array_merge(
            (array) $relations,
            [
                'assignedUsers',
                'personil',
                'dokumentasi',
                'waktu',
                'lokasiKegiatan',
                'pelanggar'
            ]
        );
        
        if ($laporan->laporanPiket()->exists()) {
            $relationsToLoad[] = 'laporanPiket.lokasiPos';
        }
        
        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan->load($relationsToLoad),
        ]);


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


}

