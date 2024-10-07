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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id')->nullable();// or uuid()
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('payment_method'); // e.g., credit card, PayPal
            $table->string('transaction_id')->nullable(); // Payment gateway transaction ID
            $table->string('status')->default('pending'); // Payment status: pending, completed, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
