<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('linkedins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_instance_id')->constrained('module_instances')->onDelete('cascade');
            $table->string('profile_url');
            $table->string('name');
            $table->string('headline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('linkedins');
    }
};
