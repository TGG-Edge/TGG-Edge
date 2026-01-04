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
        Schema::connection('mysql2')->create('campaign_check_emails', function (Blueprint $table) {
              $table->id();

            $table->string('name')->nullable();
            $table->string('email')->index();

            $table->boolean('format')->default(0);
            $table->string('domain',255)->default(0);
            $table->boolean('disposable')->default(0);
            $table->boolean('dns')->default(0);
            $table->boolean('whitelist')->default(0);

            $table->boolean('is_valid')->default(0);

            $table->json('payload')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('campaign_check_emails');
    }
};
