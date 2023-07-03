<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->text('address')->nullable();
            $table->double('fixed_charges')->nullable()->default('0');
            $table->double('cancel_charges')->nullable()->default('0');
            $table->double('min_distance')->nullable()->default('0');
            $table->double('min_weight')->nullable()->default('0');
            $table->double('per_distance_charges')->nullable()->default('0');
            $table->double('per_weight_charges')->nullable()->default('0');
            $table->tinyInteger('status')->nullable()->default('1');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('agences');
    }
}
