<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name in full (PAN Card name)
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('pan_card_number')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('purpose')->default('TGG-AID program');

            // 80G receipt reference (optional)
            $table->string('receipt_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('donations');
    }
};
