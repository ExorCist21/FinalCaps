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
        Schema::table('messages', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['conversation_id']);

            // Now drop the column
            $table->dropColumn('conversation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Recreate the column
            $table->unsignedBigInteger('conversation_id')->nullable();

            // Recreate the foreign key constraint
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }
};
