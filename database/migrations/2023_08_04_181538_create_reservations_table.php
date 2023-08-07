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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable();

            $table->integer('ville_origine_id')->nullable();
            $table->integer('ville_destination_id')->nullable();

            $table->integer('mode_expedition_id')->nullable();
            $table->string('mode_livraison')->nullable();
            $table->string('boite_postale')->nullable();
            $table->string('adresse_livraison')->nullable();

            $table->string('name_exp')->nullable();
            $table->string('email_exp')->nullable();
            $table->string('phone_exp')->nullable();

            $table->string('name_dest')->nullable();
            $table->string('email_dest')->nullable();
            $table->string('phone_dest')->nullable();

            $table->double('amount')->default('0');
            $table->double('frais_poste')->default('0');
            $table->integer('nbre_colis')->default('0');

            $table->integer('status')->default('0');
            $table->integer('active')->default('0');

            $table->integer('client_id')->nullable();
            $table->integer('agent_id')->nullable();

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
        Schema::dropIfExists('reservations');
    }
};
