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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah'); // Nama Sekolah
            $table->string('nss')->unique(); // NSS
            $table->string('npsn')->unique(); // NPSN
            $table->string('alamat'); // Alamat
            $table->string('no_telp'); // No. Telp
            $table->string('email')->unique(); // Email
            $table->string('nama_kepsek'); // Nama Kepsek
            $table->string('kecamatan_id'); // Kecamatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
