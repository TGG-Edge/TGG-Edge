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
           Schema::connection('mysql2')->table('showcases', function (Blueprint $table) {
            // add new JSON column for foundation images (image + note per item)
            if (! Schema::connection('mysql2')->hasColumn('showcases', 'tgg_foundation')) {
                $table->json('tgg_foundation')->nullable()->after('tgg_homes');
            }

            // add single checkout notes for partner cards (Modicare, Motilal)
            if (! Schema::connection('mysql2')->hasColumn('showcases', 'modicare_checkout')) {
                $table->text('modicare_checkout')->nullable()->after('tgg_foundation');
            }
            if (! Schema::connection('mysql2')->hasColumn('showcases', 'motilal_checkout')) {
                $table->text('motilal_checkout')->nullable()->after('modicare_checkout');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->table('showcases', function (Blueprint $table) {
            if (Schema::connection('mysql2')->hasColumn('showcases', 'tgg_foundation')) {
                $table->dropColumn('tgg_foundation');
            }
            if (Schema::connection('mysql2')->hasColumn('showcases', 'modicare_checkout')) {
                $table->dropColumn('modicare_checkout');
            }
            if (Schema::connection('mysql2')->hasColumn('showcases', 'motilal_checkout')) {
                $table->dropColumn('motilal_checkout');
            }
        });
    }
};
