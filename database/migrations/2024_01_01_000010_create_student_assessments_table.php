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
        Schema::create('student_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('semester');
            $table->string('academic_year');
            $table->decimal('academic_score', 5, 2)->nullable(); // Rata-rata nilai akademik
            $table->decimal('attendance_score', 5, 2)->nullable(); // Skor kehadiran
            $table->decimal('behavior_score', 5, 2)->nullable(); // Skor sikap
            $table->decimal('skill_score', 5, 2)->nullable(); // Skor keterampilan
            $table->decimal('saw_score', 5, 2)->nullable(); // Hasil perhitungan SAW
            $table->integer('rank')->nullable(); // Peringkat
            $table->timestamps();

            // Unique constraint
            $table->unique(['student_id', 'semester', 'academic_year'], 'student_assessment_unique');
            // Index untuk ranking
            $table->index(['class_id', 'semester', 'academic_year', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assessments');
    }
};
