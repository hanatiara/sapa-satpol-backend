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
        Schema::create('laporan', callback: function (Blueprint $table) {
            $table->uuid("id_laporan");
            $table->dateTime("tanggal");
            $table->string("keterangan")->nullable();
            $table->string("lokasi");
            $table->bigInteger("id_nik");

            // diisi di edit
            $table->string("tindakan_lanjutan")->nullable();
            $table->string("opd_pengampu")->nullable();
            $table->string("urusan")->nullable();
            $table->string("sumber_informasi")->nullable();
            $table->integer("jumlah_pelanggar")->nullable();
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
