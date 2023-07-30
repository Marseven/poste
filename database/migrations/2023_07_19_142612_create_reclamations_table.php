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
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('libelle')->nullable();
            $table->mediumText('details')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('agent_id')->nullable();
            $table->integer('expedition_id')->nullable();
            $table->integer('colis_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('reclamations');
    }
};
