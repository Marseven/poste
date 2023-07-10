<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societes', function (Blueprint $table) {

            $table->id();

            $table->string('code');
            $table->string('name');

            $table->string('email');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('website');
            $table->string('adresse');
            $table->string('fax');

            $table->string('immatriculation');

            $table->string('icon')->default('societe/icons/icon.png');
            $table->string('logo')->default('societe/logos/logo.png');

            $table->integer('pays_id');
            $table->integer('province_id');
            $table->integer('ville_id');

            $table->integer('active')->default('0');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societes');
    }
};
