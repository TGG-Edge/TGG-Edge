<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('literature_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('literature_id')->nullable()->constrained('literatures')->onDelete('cascade');
            $table->string('title');
            $table->foreignId('parent_id')->nullable()->constrained('literature_sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('literature_sections');
    }
};
