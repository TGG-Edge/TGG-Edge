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
        Schema::table('projects_collaborations', function (Blueprint $table) {
            //
             Schema::table('project_collaborations', function (Blueprint $table) {
               $table->integer('researcher_progress_percentage')->nullable()->default(0)->after('progress_percentage');
             });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('project_collaborations', function (Blueprint $table) {
            $table->dropColumn('researcher_progress_percentage');
        });
    }
};
