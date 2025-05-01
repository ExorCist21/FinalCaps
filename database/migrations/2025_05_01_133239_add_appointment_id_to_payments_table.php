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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');

            // Add appointment_id
            $table->unsignedBigInteger('appointment_id')->nullable()->after('id');
            $table->foreign('appointment_id')->references('appointmentID')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Rollback: add subscription_id back
            $table->unsignedBigInteger('subscription_id')->nullable()->after('id');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');

            // Drop appointment_id
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
        });
    }
};
