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
        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("lokasi");
            $table->string("judul_laporan");
            $table->string("deskripsi_laporan");
            $table->time("waktu_laporan");
            $table->time("tanggal_laporan");
            $table->string("media_laporan");
            $table->string("status_persetujuan");
            $table->string("status_laporan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
