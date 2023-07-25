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
        Schema::create('colis_expeditions', function (Blueprint $table) {

            $table->id();

            $table->string('code');
            $table->integer('service_exp_id')->nullable();

            $table->string('libelle');
            $table->mediumText('description');
            $table->string('type')->nullable();

            $table->double('poids');
            $table->double('longeur')->nullable();
            $table->double('largeur')->nullable();
            $table->double('hauteur')->nullable();

            $table->double('amount')->nullable();

            $table->string('photo')->default('expeditions/colis/colis.png');

            $table->integer('agent_id')->nullable();
            $table->integer('expedition_id')->nullable();
            $table->integer('client_id')->nullable();
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
        Schema::dropIfExists('colis_expeditions');
    }
};
