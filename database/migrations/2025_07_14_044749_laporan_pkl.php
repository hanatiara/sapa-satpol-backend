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
        Schema::create('laporan_pkl', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("jenis_pkl");
            $table->string("jenis_pelanggaran");
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
        Schema::dropIfExists('laporan_pkl');
    }
};
