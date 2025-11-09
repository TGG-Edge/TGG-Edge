<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql2')->create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 100)->unique();

            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            // Polymorphic relation for flexible linking
            $table->nullableMorphs('model');

            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();

            $table->string('currency', 10)->nullable()->default('INR');

            $table->json('items')->nullable(); // array of line items
            $table->decimal('subtotal', 12, 2)->nullable();
            $table->decimal('tax', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();

            $table->string('payment_mode', 100)->nullable();
            $table->string('transaction_id', 150)->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed', 'refunded'])
                  ->nullable()->default('pending');

            $table->text('notes')->nullable();
            $table->json('payload')->nullable(); // flexible extra data

            // ✅ Move pdf_path before timestamps (no 'after' here)
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['draft', 'pending', 'paid', 'cancelled'])
                  ->nullable()->default('draft');
                  
            $table->timestamps();

            // Optional foreign keys (only if users table exists)
            $table->foreign('source_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('target_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('invoices');
    }
};
