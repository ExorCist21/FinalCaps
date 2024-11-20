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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')->references('appointmentID')->on('appointments')->onDelete('cascade');
            $table->string('disease'); // Store the patient's disease
            $table->string('disease_type'); // Type of disease (e.g., chronic, acute)
            $table->boolean('fatal')->default(false); // Whether the disease is fatal
            $table->text('remarks')->nullable();
            $table->string('status')->nullable(); // Any additional remarks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
