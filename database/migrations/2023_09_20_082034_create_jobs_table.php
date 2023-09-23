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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->required();
            $table->integer('customer_id');
            $table->text('description')->nullable();
            $table->boolean('isRemote')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('tjmin')->nullable();
            $table->integer('tjmax')->nullable();
            $table->date('startDate')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
