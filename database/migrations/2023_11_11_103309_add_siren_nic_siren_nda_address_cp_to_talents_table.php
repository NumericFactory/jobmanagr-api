<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->string('address')->after('tjm')->nullable();
            $table->string('complementaddress')->after('address')->nullable();
            $table->integer('cp')->after('complementaddress')->nullable();
            $table->string('siren')->nullable();
            $table->string('nic')->nullable();
            $table->string('siret')->nullable();
            $table->string('nda')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->dropColumn(['siren', 'nic', 'siret', 'nda', 'address', 'complementaddress', 'cp']);
        });
    }
};




















