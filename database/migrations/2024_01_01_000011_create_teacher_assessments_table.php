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
        Schema::create('teacher_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('period'); // e.g., "January 2025", "Semester 1 2024/2025"
            $table->string('academic_year');
            $table->decimal('attendance_score', 5, 2)->nullable(); // Skor kehadiran
            $table->decimal('teaching_quality', 5, 2)->nullable(); // Kualitas mengajar
            $table->decimal('student_achievement', 5, 2)->nullable(); // Prestasi siswa
            $table->decimal('discipline_score', 5, 2)->nullable(); // Kedisiplinan
            $table->decimal('saw_score', 5, 2)->nullable(); // Hasil perhitungan SAW
            $table->integer('rank')->nullable(); // Peringkat
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint
            $table->unique(['teacher_id', 'period', 'academic_year'], 'teacher_assessment_unique');
            // Index untuk ranking
            $table->index(['period', 'academic_year', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_assessments');
    }
};
