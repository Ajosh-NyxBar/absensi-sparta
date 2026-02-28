<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('semester'); 
            $table->string('academic_year'); 
            $table->decimal('daily_test', 5, 2)->nullable(); 
            $table->decimal('midterm_exam', 5, 2)->nullable(); 
            $table->decimal('final_exam', 5, 2)->nullable(); 
            $table->decimal('final_grade', 5, 2)->nullable(); 
            $table->decimal('behavior_score', 5, 2)->nullable(); 
            $table->decimal('skill_score', 5, 2)->nullable(); 
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'semester', 'academic_year'], 'student_grade_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
