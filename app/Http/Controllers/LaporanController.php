<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Str;
use App\Models\LaporanKransos;
use App\Models\LaporanPamwal;
use App\Models\LaporanPengamanan;
use App\Models\LaporanPerizinan;
use App\Models\LaporanPiket;
use App\Models\LaporanPkl;
use App\Models\LaporanReklame;
use Carbon\Carbon;

class LaporanController extends Controller
{

    public function createLaporanKransos(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString();  // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal //dd mm yy
        ]);

        $laporan_kransos = LaporanKransos::create([
            'id_laporan' => $id_laporan,
            'lokasi' => $request->lokasi,
            'jenis_kransos' => $request->jenis_kransos,
            'deskripsi' => $request->deskripsi,
            'jenis_tindakan' => $request->jenis_tindakan,
            'jumlah_pelanggar' => $request->jumlah_pelanggar,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_kransos' => $laporan_kransos,
            'message' => $message
        ], 201);
    }

    public function createLaporanPamwal(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_pamwal = LaporanPamwal::create([
            'id_laporan' => $id_laporan,
            'lokasi' => $request->lokasi,
            'kegiatan' => $request->kegiatan,
            'pelaksanaan_kegiatan' => $request->pelaksanaan_kegiatan,
            'temuan' => $request->temuan,
            'jenis_tindakan' => $request->jenis_tindakan,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_pamwal' => $laporan_pamwal,
            'message' => $message
        ], 201);
    }

    public function createLaporanPengamanan(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_pengamanan = LaporanPengamanan::create([
            'id_laporan' => $id_laporan,
            'lokasi' => $request->lokasi,
            'pelaksanaan_kegiatan' => $request->pelaksanaan_kegiatan,
            'temuan' => $request->temuan,
            'tindakan' => $request->tindakan,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_pengamanan' => $laporan_pengamanan,
            'message' => $message
        ], 201);
    }

    public function createLaporanPerizinan(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_perizinan = LaporanPerizinan::create([
            'id_laporan' => $id_laporan,
            'lokasi' => $request->lokasi,
            'nama' => $request->nama,
            'jenis_perizinan' => $request->jenis_perizinan,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'jenis_tindakan' => $request->jenis_tindakan,
            'jumlah' => $request->jumlah,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_perizinan' => $laporan_perizinan,
            'message' => $message
        ], 201);
    }

    public function createLaporanPiket(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_piket = LaporanPiket::create([
            'id_laporan' => $id_laporan,
            'lokasi_pos' => $request->lokasi_pos,
            'pelaksanaan_kegiatan' => $request->pelaksanaan_kegiatan,
            'temuan' => $request->temuan,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_piket' => $laporan_piket,
            'message' => $message
        ], 201);
    }

    public function createLaporanPkl(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_pkl = LaporanPkl::create([
            'id_laporan' => $id_laporan,
            'jenis_pkl' => $request->jenis_pkl,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'jenis_tindakan' => $request->jenis_tindakan,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_pkl' => $laporan_pkl,
            'message' => $message
        ], 201);
    }

    public function createLaporanReklame(Request $request) {
        $id_laporan = Str::uuid();
        $tanggal = Carbon::now()->toDateTimeString(); // ganti dengan datepick

        $laporan = Laporan::create([
            'id_laporan' => $id_laporan,
            'personil' => $request->personil,
            'tanggal' => $tanggal
        ]);

        $laporan_reklame = LaporanReklame::create([
            'id_laporan' => $id_laporan,
            'nama_reklame' => $request->nama_reklame,
            'jenis_reklame' => $request->jenis_reklame,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'jumlah_reklame' => $request->jumlah_reklame,
            'jenis_tindakan' => $request->jenis_tindakan,
            'keterangan' => $request->keterangan,
            'url_dokumentasi'=> $request->url_dokumentasi,
        ]);

        $message = "Laporan berhasil dibuat.";

        return response()->json([
            'laporan' => $laporan,
            'laporan_reklame' => $laporan_reklame,
            'message' => $message
        ], 201);
    }

    public function showAllLaporan() {
        $laporan = Laporan::with(['laporanKransos','laporanPamwal','laporanPengamanan','laporanPerizinan','laporanPiket','laporanPkl'])
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return response()->json([
            'total' => $this->countLaporan(),
            'laporan' => $laporan,
        ], 200);
    }

    public function showToday() {
        $today = Carbon::today();
        $laporan = Laporan::with(['laporanKransos','laporanPamwal','laporanPengamanan','laporanPerizinan','laporanPiket','laporanPkl'])
                    ->whereDate('tanggal', $today)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return response()->json([
            'total' => $laporan->count(),
            'laporan' => $laporan,
        ], 200);
    }

    public function countLaporan() {
        return Laporan::count();
    }
}





