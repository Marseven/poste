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
        Schema::create('mouchards', function (Blueprint $table) {
            $table->id();

            $table->string('ip_adresse');
            $table->string('os_system')->nullable();
            $table->string('os_navigator')->nullable();

            $table->string('phone_brand')->nullable();
            $table->string('phone_imei')->nullable();

            $table->string('action_title')->nullable();
            $table->mediumText('action_system')->nullable();

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
        Schema::dropIfExists('mouchards');
    }
};
