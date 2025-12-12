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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('registration_id');
            $table->unsignedBigInteger('path_requirement_id');
            $table->string('path')->nullable(); // Path to the uploaded document
            $table->string('status')->default('pending'); // Status of the document
            $table->text('alasan_reject')->nullable(); // Reason for rejection, if any
            $table->timestamps();

            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
            $table->foreign('path_requirement_id')->references('id')->on('path_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->dropForeign(['path_requirement_id']);
        });
        Schema::dropIfExists('documents');
    }
};
