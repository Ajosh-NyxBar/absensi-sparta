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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('semester'); // e.g., "Ganjil", "Genap"
            $table->string('academic_year'); // e.g., "2024/2025"
            $table->decimal('daily_test', 5, 2)->nullable(); // Ulangan harian
            $table->decimal('midterm_exam', 5, 2)->nullable(); // UTS
            $table->decimal('final_exam', 5, 2)->nullable(); // UAS
            $table->decimal('final_grade', 5, 2)->nullable(); // Nilai akhir
            $table->decimal('behavior_score', 5, 2)->nullable(); // Nilai sikap
            $table->decimal('skill_score', 5, 2)->nullable(); // Nilai keterampilan
            $table->text('notes')->nullable();
            $table->timestamps();

            // Unique constraint: satu siswa tidak bisa punya nilai ganda untuk mata pelajaran yang sama di semester yang sama
            $table->unique(['student_id', 'subject_id', 'semester', 'academic_year'], 'student_grade_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
