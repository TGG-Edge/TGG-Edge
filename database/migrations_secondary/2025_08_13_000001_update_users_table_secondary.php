<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('rhm_number')->nullable();
            $table->string('image')->nullable();
            $table->enum('user_role', ['admin', 'trainer', 'members', 'rhm-club', 'nomad-community', 'freelancers'])->default('Members');
            $table->enum('approval', ['pending', 'accepted', 'rejected'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'rhm_number', 'image', 'user_role','approval']);
        });
    }
};
