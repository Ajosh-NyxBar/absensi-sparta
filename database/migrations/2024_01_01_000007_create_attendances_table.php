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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('attendable_type'); // Teacher or Student
            $table->unsignedBigInteger('attendable_id');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['present', 'late', 'absent', 'sick', 'permission'])->default('present');
            $table->string('latitude_in')->nullable(); // Geolocation check-in
            $table->string('longitude_in')->nullable();
            $table->string('latitude_out')->nullable(); // Geolocation check-out
            $table->string('longitude_out')->nullable();
            $table->string('qr_code')->nullable(); // QR Code untuk guru
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index untuk polymorphic relation
            $table->index(['attendable_type', 'attendable_id']);
            // Index untuk pencarian berdasarkan tanggal
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
