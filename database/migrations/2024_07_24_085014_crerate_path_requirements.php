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
        Schema::create('path_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_path_id')->constrained()->onDelete('cascade');
            $table->uuid('document_type_id');  // Changed to reference document_types table
            $table->string('jenjang')->nullable();
            $table->boolean('is_required')->default(true);
            $table->string('allowed_file_types')->nullable();  // e.g., 'pdf,jpg,png'
            $table->integer('max_file_size')->nullable();      // in KB
            $table->integer('display_order')->default(0);      // For controlling display order in UI
            $table->json('validation_rules')->nullable();      // Additional validation rules if needed
            $table->timestamps();

            // Foreign key for document_type_id
            $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('path_requirements');
    }
};
