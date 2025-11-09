<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('feature_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_instance_id')->constrained('module_instances')->onDelete('cascade');
            $table->foreignId('feature_id')->constrained('module_features')->onDelete('cascade');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('feature_items');
    }
};
