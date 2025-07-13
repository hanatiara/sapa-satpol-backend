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
        Schema::create('absensi', function (Blueprint $table) {
            $table->uuid("id_absensi");
            $table->string("lokasi");
            $table->date("tanggal_piket");
            $table->time("waktu_mulai_piket");
            $table->time("waktu_selesai_piket");
            $table->string("shift");
            $table->string("pos_piket");
            $table->string("tindakan_piket");
            $table->string("nama_personil");
            $table->string("keterangan_piket");
            $table->string("media_piket");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
