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
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('fullname', 100)->unique();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->default('female')->nullable();
            $table->string('phone', 12)->unique();
            $table->string('address', 255);
            $table->integer('body_height');
            $table->integer('body_weight');
            $table->date('start_working')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};
