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
        Schema::create('parametre_sms', function (Blueprint $table) {

            $table->id();

            $table->string('libelle');
            $table->string('region');
            $table->string('key_type');
            $table->string('sid');
            $table->string('secret');

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
        Schema::dropIfExists('parametre_sms');
    }
};
