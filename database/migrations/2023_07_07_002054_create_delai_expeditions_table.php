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
        Schema::create('delai_expeditions', function (Blueprint $table) {

            $table->id();

            $table->string('code');
            $table->string('libelle');
            $table->mediumText('description');

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
        Schema::dropIfExists('delai_expeditions');
    }
};
