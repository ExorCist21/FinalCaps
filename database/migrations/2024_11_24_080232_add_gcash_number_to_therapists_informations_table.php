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
            $table->string('gcash_number', 15)->nullable()->after('expertise');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapist_informations', function (Blueprint $table) {
            $table->dropColumn('gcash_number');
        });
    }
};
