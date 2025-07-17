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

    public function countLaporan() {
        return Laporan::count();
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
}

