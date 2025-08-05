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
        Schema::create('laporan_pengamanan', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("lokasi");
            $table->string("pelaksanaan_kegiatan");
            $table->string("tindakan");
            $table->string("temuan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengamanan');
    }
};
