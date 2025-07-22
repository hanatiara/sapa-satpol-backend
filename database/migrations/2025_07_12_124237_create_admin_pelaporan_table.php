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
        Schema::create('admin_pelaporan', function (Blueprint $table) {
            $table->id("id_nik");
            $table->string("nama_admin_pelaporan");
            $table->string("password");
            $table->string("email_admin");
            $table->string("jabatan");
            $table->string("alamat");
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_pelaporan');
    }
};
