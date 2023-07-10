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
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('noms')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('genre')->nullable();

            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('type_document')->nullable();
            $table->string('numero_document')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('role')->default('Admin');
            $table->string('adresse')->nullable();
            $table->string('avatar')->default(url('avatars/avatar.png'));


            $table->string('code_secret')->nullable();
            $table->string('api_token')->nullable();

            $table->integer('abonne')->default('0');
            $table->integer('status')->default('0');
            $table->integer('active')->default('0');

            $table->integer('agence_id')->nullable();


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
