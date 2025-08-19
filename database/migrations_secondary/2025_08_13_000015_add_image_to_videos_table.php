<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::connection('mysql2')->table('videos', function (Blueprint $table) {
            $table->string('image')->nullable()->after('url'); // Add image column
        });
    }

    public function down(): void
    {

         Schema::connection('mysql2')->table('videos', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
