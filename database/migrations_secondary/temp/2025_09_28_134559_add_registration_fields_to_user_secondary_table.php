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
            if (!Schema::hasColumn('users', 'age')) {
                $table->integer('age')->nullable()->after('name');
            }

            $table->string('nationality')->nullable()->after('age');
            $table->enum('gender', ['Male', 'Female', 'Prefer not to say'])->nullable()->after('nationality');
            $table->string('area_of_expertise')->nullable()->after('gender');
            $table->boolean('responsible_human_mission')->default(0)->after('area_of_expertise');
            $table->string('linkedin_profile')->nullable()->after('responsible_human_mission');
            $table->boolean('consent_declaration')->default(0)->after('linkedin_profile');
            $table->string('pin_code')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('users');
    }
};
