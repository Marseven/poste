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
        Schema::create('parametre_paiements', function (Blueprint $table) {
            $table->id();

            $table->string('ebilling_id')->nullable();
            $table->string('operator')->nullable();
            $table->string('token')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();


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
        Schema::dropIfExists('parametre_paiements');
    }
};
