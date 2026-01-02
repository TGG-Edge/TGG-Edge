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
         Schema::connection('mysql2')->create('user_id_proofs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();

            $table->string('id_proof_type')->nullable(); // Aadhaar / PAN / etc.
            $table->string('id_proof_number')->nullable();
            $table->string('id_proof_file')->nullable(); // upload path

            $table->timestamps();

            // Reference to users table in main db
            // (optional if users table is in another connection)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::connection('mysql2')->dropIfExists('user_id_proofs');
    }
};
