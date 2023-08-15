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
        Schema::create('notification_mobiles', function (Blueprint $table) {

            $table->id();

            $table->integer('sender_id')->nullable();
            $table->integer('receiver_id')->nullable();

            $table->string('code')->unique();
            $table->string('libelle')->nullable();
            $table->mediumText('details')->nullable();

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
        Schema::dropIfExists('notification_mobiles');
    }
};
