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
            $table->string('name')->required();
            $table->enum('type', ['ecole', 'entreprise', 'organisme public']);
            $table->boolean('isorganismeformation');
            $table->string('siren', 9)->nullable();
            $table->string('nic', 5)->nullable();
            $table->string('siret', 14)->nullable();
            $table->string('address');
            $table->string('complementaddress')->nullable();
            $table->string('cp')->nullable();
            $table->string('city');
            $table->string('country')->nullable();
            $table->timestamps();
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
