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
        Schema::table('therapist_informations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('awards')->nullable()->after('updated_at');
            $table->string('clinic_name')->nullable()->after('awards');
            $table->string('expertise')->nullable()->after('clinic_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapist_informations', function (Blueprint $table) {
            $table->dropColumn(['awards', 'clinic_name', 'expertise','user_id']);
        });
    }
};
