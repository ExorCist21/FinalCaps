<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointmentID');
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('medicine_name')->nullable();
            $table->string('medicine_duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('appointmentID')->references('appointmentID')->on('appointments')->onDelete('cascade');
            $table->foreign('therapist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
