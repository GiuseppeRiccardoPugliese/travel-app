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
        Schema::table('trip_user', function(Blueprint $table){
            $table->foreignId('trip_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });

        //RELAZIONE TRIP - JOURNEY_STAGES 1 / N
        Schema::table('journey_stages', function(Blueprint $table){
            $table->foreignId('trip_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //DROP TABELLA PONTE USER - TRIP M / N
        Schema::table('trip_user', function(Blueprint $table){
            $table->dropForeign('trip_user_trip_id_foreign');
            $table->dropColumn('trip_id');

            $table->dropForeign('trip_user_user_id_foreign');
            $table->dropColumn('user_id');
        });

        //RELAZIONE TRIP - JOURNEY_STAGES 1 / N
        Schema::table('journey_stages', function(Blueprint $table){
            $table->dropForeign('journey_stages_trip_id_foreign');
            $table->dropColumn('trip_id');
        });
    }
};
