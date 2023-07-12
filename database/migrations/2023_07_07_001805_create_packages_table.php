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
        Schema::create('packages', function (Blueprint $table) {

            $table->id();

            $table->string('code');
            $table->string('libelle');
            $table->mediumText('description');

            $table->integer('ville_origine_id')->nullable();
            $table->integer('ville_destination_id')->nullable();

            $table->integer('agence_origine_id')->nullable();
            $table->integer('agence_destination_id')->nullable();

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
        Schema::dropIfExists('packages');
    }
};