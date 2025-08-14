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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('project')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('rhm_number')->nullable();
            $table->boolean('research_assistance')->default(false);
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('user_type')->nullable();
            $table->unsignedTinyInteger('user_role')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
