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
            $table->string('nama'); // Nama
            $table->string('tempat_lahir'); // Tempat Lahir
            $table->date('tanggal_lahir'); // Tanggal Lahir
            $table->string('nama_bapak_ibu'); // Nama Bapak Ibu
            $table->string('nik')->unique(); // NIK
            $table->string('no_kk')->unique(); // No. KK
            $table->string('no_hp_ortu'); // No. HP Ortu
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
