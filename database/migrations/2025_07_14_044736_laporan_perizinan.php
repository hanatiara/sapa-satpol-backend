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
            $table->string("lokasi");
            $table->string("nama");
            $table->string("jenis_perizinan");
            $table->string("jenis_pelanggaran");
            $table->string("jenis_tindakan");
            $table->double("jumlah");
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
