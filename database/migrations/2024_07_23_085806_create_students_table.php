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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jenjang')->nullable();
            $table->integer('nisn')->unique()->nullable();
            $table->string('nama'); // Nama
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir'); // Tempat Lahir
            $table->date('tanggal_lahir'); // Tanggal Lahir
            $table->string('nama_bapak');
            $table->string('nama_ibu');
            $table->string('nik')->unique(); // NIK
            $table->string('no_kk')->unique(); // No. KK
            $table->string('no_hp_ortu'); // No. HP Ortu
            $table->string('alamat'); // Email Ortu
            $table->string('foto')->nullable();
            $table->string('foto_url')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('students');
    }
};
