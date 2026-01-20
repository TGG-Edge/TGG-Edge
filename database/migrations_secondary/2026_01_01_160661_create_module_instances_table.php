<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('module_instance_assigns', function (Blueprint $table) {
            $table->id();
            $table->json('module_instance_ids')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('module_instance_assigns');
    }
};
