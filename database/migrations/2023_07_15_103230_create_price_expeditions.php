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
        Schema::create('price_expeditions', function (Blueprint $table) {
            $table->id();
            $table->integer('zone_id');
            $table->integer('service_id');
            $table->integer('mode_id');

            $table->string('type')->nullable();
            $table->integer('first')->nullable();
            $table->string('type_element')->nullable();
            $table->double('weight')->nullable();
            $table->double('price');
            $table->string('fees_sup')->nullable();
            $table->string('label_fees')->nullable();

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
        Schema::dropIfExists('price_expeditions');
    }
};
