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
        Schema::connection('mysql2')->create('faqs', function (Blueprint $table) {
             $table->id();

            $table->unsignedBigInteger('category_id');
            $table->text('title');
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign key: category
            $table->foreign('category_id')
                  ->references('id')
                  ->on('faq_categories')
                  ->onDelete('cascade');

            // Self reference foreign key
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('faqs')
                  ->onDelete('cascade');

            // Optional: admin reference (if users table exists)
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
