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
        Schema::connection('mysql2')->create('faq_categories', function (Blueprint $table) {
             $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();

            // Self reference foreign key
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('faq_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_categories');
    }
};
