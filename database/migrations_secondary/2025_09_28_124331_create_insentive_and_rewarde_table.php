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
          Schema::connection('mysql2')->create('incentives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('source_id')->nullable(); // who gave it
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();  
            $table->string('target_type')->nullable();             // who receives
            $table->text('description')->nullable();
            $table->string('reason')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            
            $table->string('status')->default('pending'); // pending/complete/reject
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('target_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::connection('mysql2')->create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('source_id')->nullable(); // who gave it
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
             $table->string('target_type')->nullable();             // who receives
            $table->text('description')->nullable();
            $table->string('reason')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            
            $table->string('status')->default('pending'); // pending/complete/reject
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('target_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::connection('mysql2')->dropIfExists('incentives');
        Schema::connection('mysql2')->dropIfExists('rewards');
    }
};
