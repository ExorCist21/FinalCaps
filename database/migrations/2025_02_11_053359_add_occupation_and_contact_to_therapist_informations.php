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
            $table->string('occupation')->nullable()->after('expertise');
            $table->string('contact_number')->nullable()->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('therapist_informations', function (Blueprint $table) {
            $table->dropColumn(['occupation', 'contact_number']);
        });
    }
};
