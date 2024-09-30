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
        Schema::create('registration_periods', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('tahun_ajaran'); // Name of the registration period (optional)
            $table->date('start_date'); // Start date of the registration period
            $table->date('end_date'); // End date of the registration period
            $table->boolean('is_open')->default(false); // Flag to indicate if registration is open
            $table->timestamps(); // Laravel default created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_periods');
    }
};
