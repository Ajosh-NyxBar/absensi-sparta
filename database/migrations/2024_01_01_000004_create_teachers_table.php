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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip')->unique(); // Nomor Induk Pegawai
            $table->string('name');
            $table->enum('gender', ['L', 'P']); // Laki-laki, Perempuan
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('education_level')->nullable(); // S1, S2, S3
            $table->string('position')->nullable(); // Guru Mapel, Wali Kelas, etc
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
