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
        Schema::connection('mysql2')->create('showcases', function (Blueprint $table) {
            $table->id();
            $table->text('welcome_note')->nullable();
            $table->json('entrepreneurship_opportunities')->nullable(); // multiple text entries
            $table->json('woodpecker_collection')->nullable(); // multiple image URLs
            $table->json('travel_and_events')->nullable(); // multiple image URLs
            $table->json('tgg_homes')->nullable(); // multiple image URLs
            $table->json('tgg_news')->nullable(); // multiple YouTube URLs
            $table->json('investment_opportunities')->nullable(); // multiple text/links
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('showcases');
    }
};
