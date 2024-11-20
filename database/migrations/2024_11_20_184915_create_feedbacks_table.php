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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')->references('appointmentID')->on('appointments')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->nullable(); 
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable(); 
            $table->timestamps();
    
            $table->unique(['appointment_id', 'patient_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
