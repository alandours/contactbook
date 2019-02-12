<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_contact');
            $table->unsignedBigInteger('id_network');
            $table->string('username', 80);
            $table->string('custom_tag', 50)->nullable();

            $table->foreign('id_contact')->references('id')->on('contacts');
            $table->foreign('id_network')->references('id')->on('networks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social');
    }
}
