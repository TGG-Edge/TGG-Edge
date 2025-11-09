<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('feature_limits', function (Blueprint $table) {
            $table->id();
            $table->string('feature_key');
            $table->integer('free_limit')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('feature_limits');
    }
};
