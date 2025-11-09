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
            $table->text('welcome_note_trainer')->nullable()->after('welcome_note');
            $table->text('welcome_note_member')->nullable()->after('welcome_note_trainer');
            $table->text('welcome_note_rhm_club')->nullable()->after('welcome_note_member');
            $table->text('welcome_note_nomad_community')->nullable()->after('welcome_note_rhm_club');
            $table->text('welcome_note_freelancer')->nullable()->after('welcome_note_nomad_community');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->table('showcases', function (Blueprint $table) {
            $table->dropColumn([
                'welcome_note_trainer',
                'welcome_note_member',
                'welcome_note_rhm_club',
                'welcome_note_nomad_community',
                'welcome_note_freelancer',
            ]);
        });
    }
};
