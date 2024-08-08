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
        //TABELLA PONTE USER - TRIP M / N
        Schema::table('user_trip', function(Blueprint $table){
            $table->foreignId('user_id')->constrained();
            $table->foreignId('trip_id')->constrained();
        });

        //RELAZIONE TRIP - JOURNEY_STAGES 1 / N
        Schema::table('journeystages', function(Blueprint $table){
            $table->foreignId('trip_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //DROP TABELLA PONTE USER - TRIP M / N
        Schema::table('user_trip', function(Blueprint $table){
            $table->dropForeign('user_trip_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('user_trip_trip_id_foreign');
            $table->dropColumn('trip_id');
        });

        //RELAZIONE TRIP - JOURNEY_STAGES 1 / N
        Schema::table('journeystages', function(Blueprint $table){
            $table->dropForeign('journeystages_trip_id_foreign');
            $table->dropColumn('trip_id');
        });
    }
};
