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
        Schema::create('ai_research_assistances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->json('literature')->nullable(); // JSON of research notes/articles
            $table->json('videos')->nullable();     // JSON of video links/details
            $table->json('links')->nullable();      // JSON of helpful URLs
            $table->json('linkedin')->nullable();   // JSON of LinkedIn profiles or data

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_research_assistances');
    }
};
