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
        Schema::create('laporan_piket', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("status_kegiatan");
            $table->string("lokasi_pos");
            $table->string("shift_piket");
            $table->string("kejadian");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_piket');
    }
};
