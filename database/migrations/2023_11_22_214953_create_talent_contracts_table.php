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
        Schema::create('talent_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('ref')->nullable();
            $table->boolean('signed')->default(false);
            $table->integer('talent_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_contracts');
    }
};
