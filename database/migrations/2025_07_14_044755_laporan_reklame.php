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
        Schema::create('laporan_reklame', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("nama_reklame");
            $table->string("jenis_reklame");
            $table->string("jenis_pelanggaran");
            $table->double("jumlah_reklame");
            $table->string("jenis_tindakan");
            $table->string("keterangan");
            $table->string("url_dokumentasi");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_reklame');
    }
};
