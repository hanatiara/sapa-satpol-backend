<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\LaporanHandlerResolver;

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
        $relations = array_values($this->relationMap);

        $laporan = Laporan::with($relations)->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'total' => $laporan->count(),
            'laporan' => $laporan,
        ], 200);
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
        $id_laporan = $request->id_laporan;
        $relations = array_values($this->relationMap);
        $laporan = Laporan::with($relations)->find($id_laporan);

        if(!$laporan) {
            return response()->json(['message' => 'Laporan not found'], 404);
        }

        return response()->json([
            'laporan' => $laporan,
        ], 200);
    }

    public function updateLaporan(Request $request, LaporanHandlerResolver $resolver) {
        $id_laporan = $request->id_laporan;

        $laporan = Laporan::findOrFail($id_laporan);

        $type = $request->type;

        $laporan->update([
            'personil' => $request->personil ?? $laporan->personil,
            'tanggal' => $request->tanggal ?? $laporan->tanggal,
        ]);

        $handler = $resolver->resolveByType($type);
        $handler->update($laporan, $request->all());

        $relation = $this->relationMap[$type] ?? null;

        return response()->json([
            'message' => 'Laporan berhasil diperbarui',
            'data' => $laporan->load([$relation]),
        ]);
    }

    public function createLaporan(Request $request, LaporanHandlerResolver $resolver) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal,
            'type' => $request->type,
        ]);

        $handler = $resolver->resolveByType($request->type);
        $handler->create($laporan, $request->all());

        $relation = $this->relationMap[$request->type] ?? null;

        return response()->json([
            'message' => 'Laporan berhasil dibuat',
            'data' => $laporan->load([$relation]),
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
}

