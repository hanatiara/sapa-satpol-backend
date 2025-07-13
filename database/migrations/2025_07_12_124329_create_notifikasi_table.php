<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid("id_kegiatan");
            $table->string("sub_kegiatan");
            $table->string("lokasi");
            $table->time("waktu_mulai");
            $table->time("waktu_selesai");
            $table->string("jenis_kegiatan");
            $table->string("jenis_pelanggaran");
            $table->string("jenis_tindakan");
            $table->string("nama_personil");
            $table->string("keterangan_kegiatan");
            $table->string("media_kegiatan");
            $table->string("nama_pelanggar");
            $table->double("nik_pelanggar");
            $table->string("jk_pelanggar");
            $table->string("alamat_pelanggar");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
