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

            $table->string('code');
            $table->string('reference');

            $table->integer('agence_exp_id')->nullable();
            $table->integer('agence_dest_id')->nullable();

            $table->string('name_exp');
            $table->string('phone_exp');
            $table->string('email_exp');
            $table->string('adresse_exp');

            $table->string('name_dest');
            $table->string('phone_dest');
            $table->string('email_dest');
            $table->string('adresse_dest');

            $table->boolean('address');
            $table->string('bp')->nullable();
            $table->integer('mode_exp_id')->nullable();
            $table->integer('delai_exp_id')->nullable();
            $table->double('amount')->nullable();
            $table->integer('methode_paiement_id')->nullable();
            $table->integer('nbre_colis')->nullable();
            $table->string('etape_id')->nullable();

            $table->integer('client_id')->nullable();
            $table->integer('agent_id')->nullable();
            $table->integer('status')->nullable();
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
