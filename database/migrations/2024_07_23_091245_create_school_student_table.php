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
        Schema::create('school_student', function (Blueprint $table) {
            $table->id();
            $table->uuid('student_id'); // UUID for student
            $table->uuid('school_id');  // UUID for school
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_student', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['school_id']);
        });
        Schema::dropIfExists('school_student');
    }
};
