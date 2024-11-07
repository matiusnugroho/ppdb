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
            $table->uuid('id')->primary();
            $table->string('nama_sekolah'); // Nama Sekolah
            $table->string('nss')->unique(); // NSS
            $table->string('npsn')->unique(); // NPSN
            $table->string('jenjang'); // Jenjang
            $table->string('alamat'); // Alamat
            $table->string('no_telp'); // No. Telp
            $table->string('email')->unique(); // Email
            $table->string('nama_kepsek'); // Nama Kepsek
            $table->string('kecamatan_id'); // Kecamatan
            $table->unsignedBigInteger('user_id');
            $table->integer('daya_tampung')->default(10);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('schools');
    }
};
