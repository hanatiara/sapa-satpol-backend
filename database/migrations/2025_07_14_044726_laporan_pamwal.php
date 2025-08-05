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
        Schema::create('laporan_pamwal', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("lokasi");
            $table->string("kegiatan");
            $table->string("pelaksanaan_kegiatan");
            $table->string("temuan");
            $table->string("jenis_tindakan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pamwal');
    }
};
