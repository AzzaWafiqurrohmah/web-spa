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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->cascadeOnDelete();
            $table->string('fullname', 100)->nullable(false);
            $table->string('phone', 12)->nullable(false);
            $table->tinyInteger('is_member')->nullable(false);
            $table->date('start_member');
            $table->string('address', 255);
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('home_pict');
            $table->string('home_details');
            $table->string('latitude');
            $table->string('longtitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
