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
        Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->string('last')->required();
            $table->string('first')->nullable();
            $table->integer('xp')->nullable();
            $table->integer('tjm')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('remote')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('indicatifphone')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talents');
    }
};
