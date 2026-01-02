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
        Schema::connection('mysql2')->create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // general, global, email, seo
            $table->string('key')->index();   // site_name, entitlement_rules
            $table->longText('value')->nullable(); // actual value (string/json)
            $table->string('type')->default('text'); // text, json, boolean, image
            $table->string('label')->nullable(); // Human readable label

            $table->boolean('is_editable')->default(true);
            $table->integer('order')->default(0);

            $table->timestamps();

            $table->unique(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('settings');
    }
};
