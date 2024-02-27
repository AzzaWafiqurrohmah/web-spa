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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('therapist_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date')->nullable(false);
            $table->enum('payment_type', ['cash', 'transfer']);
            $table->integer('transfer_cost')->nullable(false);
            $table->integer('discount')->default(0);
            $table->integer('totals')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
