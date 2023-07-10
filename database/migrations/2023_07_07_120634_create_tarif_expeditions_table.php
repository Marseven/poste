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
        Schema::create('tarif_expeditions', function (Blueprint $table) {

            $table->id();

            $table->string('code');

            $table->string('pays_exp')->nullable();
            $table->string('province_exp')->nullable();
            $table->string('ville_exp')->nullable();

            $table->string('pays_dest')->nullable();
            $table->string('province_dest')->nullable();
            $table->string('ville_dest')->nullable();

            $table->double('poids_min')->nullable();
            $table->double('poids_max')->nullable();

            $table->double('tarif')->nullable();

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
        Schema::dropIfExists('tarif_expeditions');
    }
};
