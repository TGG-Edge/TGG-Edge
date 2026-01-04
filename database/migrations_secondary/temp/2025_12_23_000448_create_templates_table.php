<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['email', 'whatsapp', 'sms', 'notification']);
            $table->string('title')->nullable(); // email subject / notification title
            $table->json('content'); // { body, variables }
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('templates');
    }
};
