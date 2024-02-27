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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_catagory_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('franchise_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name', 100)->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->string('pictures');
            $table->date('period_start')->nullable(false);
            $table->date('period_end')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->integer('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
