<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubscriptionsTableDuration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Remove the start_date and end_date columns
            $table->dropColumn(['start_date', 'end_date']);
            
            // Add the duration column
            $table->integer('duration')->after('service_name')->comment('Duration in months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Re-add the start_date and end_date columns
            $table->timestamp('start_date')->nullable()->default(DB::raw('current_timestamp'))->after('service_name');
            $table->timestamp('end_date')->nullable()->after('start_date');
            
            // Remove the duration column
            $table->dropColumn('duration');
        });
    }
}
