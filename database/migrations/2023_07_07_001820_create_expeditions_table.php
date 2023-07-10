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
        Schema::create('expeditions', function (Blueprint $table) {

            $table->id();

            $table->string('code_agence');
            $table->string('code_aleatoire');
            $table->string('reference');

            $table->integer('agence_id')->nullable();

            $table->string('name_exp');
            $table->string('phone_exp');
            $table->string('email_exp');
            $table->string('adresse_exp');

            $table->string('name_dest');
            $table->string('phone_dest');
            $table->string('email_dest');
            $table->string('adresse_dest');

            $table->integer('service_exp_id')->nullable();
            $table->integer('forfait_exp_id')->nullable();
            $table->integer('mode_exp_id')->nullable();

            $table->integer('methode_exp_id')->nullable();
            $table->integer('delai_exp_id')->nullable();
            $table->integer('temps_exp_id')->nullable();

            $table->integer('tarif_exp_id')->nullable();

            $table->integer('mode_paiement_id')->nullable();
            $table->integer('methode_paiement_id')->nullable();

            $table->integer('client_id')->nullable();
            $table->integer('agent_id')->nullable();
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
        Schema::dropIfExists('expeditions');
    }
};
