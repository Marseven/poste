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
        Schema::create('paiements', function (Blueprint $table) {

            $table->id();

            $table->string('reference');
            $table->integer('client_id')->nullable();
            $table->integer('expedition_id')->nullable();
            $table->double('amount')->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('status')->nullable();
            $table->integer('timeout')->nullable();
            $table->string('ebilling_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('operator')->nullable();
            $table->datetime('expired_at')->nullable();
            $table->datetime('paid_at')->nullable();

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
        Schema::dropIfExists('paiements');
    }
};
