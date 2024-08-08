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
        Schema::create('journeystages', function (Blueprint $table) {
            $table->id();

            $table->string('nome');                
            $table->text('descrizione')->nullable(); 
            $table->string('posizione');            
            $table->date('data')->nullable();      
            $table->integer('ordine')->default(0); 
            $table->boolean('completata')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journeystages');
    }
};
