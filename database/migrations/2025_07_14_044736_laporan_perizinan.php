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
        Schema::create('laporan_perizinan', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("judul");
            $table->string("deskripsi_kejadian");
            $table->string("status_penanganan");
            $table->DateTime("tanggal_kejadian");
            $table->string("waktu_kejadian");
            $table->string("nama_usaha");
            $table->string("jenis_perizinan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perizinan');
    }
};
