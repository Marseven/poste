<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bags', function (Blueprint $table) {
            $table->id();
            $table->json('pickup_point')->nullable();
            $table->json('delivery_point')->nullable();
            $table->double('total_weight')->nullable()->default('0');
            $table->double('total_distance')->nullable()->default('0');
            $table->dateTime('date')->nullable();
            $table->dateTime('pickup_datetime')->nullable();
            $table->dateTime('delivery_datetime')->nullable();
            $table->string('status')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bags');
    }
}
