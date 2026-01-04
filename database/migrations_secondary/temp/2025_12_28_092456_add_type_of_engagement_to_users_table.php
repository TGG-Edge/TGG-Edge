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
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->string('type_of_engagement', 100)
                  ->nullable()
                  ->after('id');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->table('users', function (Blueprint $table) {
            $table->dropColumn('type_of_engagement');
        });
    }
};
