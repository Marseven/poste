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
        Schema::create('suivi_packages', function (Blueprint $table) {

            $table->id();

            $table->string('code');
            $table->string('etape_id');
            $table->string('status');
            $table->mediumText('rapport');

            $table->integer('package_id')->nullable();

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
        Schema::dropIfExists('suivi_packages');
    }
};
