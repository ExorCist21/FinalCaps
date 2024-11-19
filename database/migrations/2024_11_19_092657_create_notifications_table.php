<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notificationID');
            $table->unsignedBigInteger('n_userID')->nullable();
            $table->foreign('n_userID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
            $table->string('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
