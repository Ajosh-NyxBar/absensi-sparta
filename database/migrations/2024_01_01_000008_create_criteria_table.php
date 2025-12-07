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
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., "C1", "C2", "C3"
            $table->string('name'); // e.g., "Nilai Akademik", "Kehadiran", "Sikap"
            $table->enum('type', ['benefit', 'cost']); // benefit: semakin besar semakin baik, cost: sebaliknya
            $table->decimal('weight', 5, 2); // Bobot kriteria (0.00 - 1.00)
            $table->enum('for', ['student', 'teacher']); // Untuk siswa atau guru
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
