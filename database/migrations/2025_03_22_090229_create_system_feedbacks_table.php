<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('system_feedbacks', function (Blueprint $table) {
            $table->id('feedbackID'); // Auto-increment ID
            $table->unsignedBigInteger('userID')->nullable();
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            $table->text('system_feedback')->nullable(); 
            $table->integer('system_rating')->nullable(); 
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_feedbacks');
    }
};
