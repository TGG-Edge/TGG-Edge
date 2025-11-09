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
       Schema::connection('mysql2')->table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->nullable()->after('payer_type');
            $table->string('source_type')->nullable()->after('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->table('payments', function (Blueprint $table) {
            $table->dropColumn('source_id');
            $table->dropColumn('source_type');
        });
    }
};
