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
       Schema::create('laporan_kransos', function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->string("judul");
            $table->date("tanggal_kejadian");
            $table->time("waktu_kejadian"); 
            $table->string("jenis_kransos");
            $table->string("status_penanganan");
            $table->string("deskripsi_kejadian");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kransos');
    }
};
