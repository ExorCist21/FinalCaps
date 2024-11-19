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
        Schema::create('content', function (Blueprint $table) {
            $table->bigIncrements('content_id'); // Primary key
            $table->unsignedBigInteger('creatorID'); // Foreign key
            $table->string('description'); // Description column
            $table->string('title'); // Title column
            $table->string('url'); // URL column
            $table->string('image_path'); // Image path column
            $table->timestamps();

            // Setting the foreign key constraint
            $table->foreign('creatorID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};
