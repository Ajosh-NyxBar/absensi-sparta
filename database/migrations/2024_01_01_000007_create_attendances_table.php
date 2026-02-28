<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('attendable_type'); 
            $table->unsignedBigInteger('attendable_id');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['present', 'late', 'absent', 'sick', 'permission'])->default('present');
            $table->string('latitude_in')->nullable(); 
            $table->string('longitude_in')->nullable();
            $table->string('latitude_out')->nullable(); 
            $table->string('longitude_out')->nullable();
            $table->string('qr_code')->nullable(); 
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['attendable_type', 'attendable_id']);
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
