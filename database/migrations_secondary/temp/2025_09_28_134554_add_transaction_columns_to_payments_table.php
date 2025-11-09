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
              $table->string('transaction_id')->nullable()->after('status'); // Razorpay payment ID
            $table->string('payment_method')->nullable()->after('transaction_id'); // card, upi, etc.
            $table->string('currency')->default('INR')->after('payment_method'); // currency
            $table->text('meta')->nullable()->after('currency'); // JSON for extra info
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('payments');
    }
};
