<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('created_by');
            $table->json('payload')->nullable(); // sender config / defaults
            $table->enum('type', ['email', 'whatsapp', 'sms', 'notification']);
            $table->enum('status', ['pending', 'running', 'completed'])->default('pending');
            $table->timestamps();

            $table->foreign('template_id')
                  ->references('id')
                  ->on('templates')
                  ->onDelete('cascade');

            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('campaigns');
    }
};
