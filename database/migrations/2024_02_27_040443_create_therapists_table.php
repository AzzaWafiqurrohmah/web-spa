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
            $table->string('raw_id', 5)->nullable(false);
            $table->string('fullname', 100)->nullable(false);
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female'])->default('female');
            $table->string('phone', 12)->nullable(false);
            $table->string('address', 255)->nullable(false);
            $table->integer('body_height')->nullable(false);
            $table->integer('body_weight')->nullable(false);
            $table->timestamp('start_working')->useCurrent();
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
