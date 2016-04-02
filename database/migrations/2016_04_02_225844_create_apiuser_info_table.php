<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiuserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apiuser_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('mobile');
            $table->integer('apiuser_id')->unsigned();
            $table->integer('area_id')->unsigned()->nullable();
            $table->integer('position_id')->unsigned()->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();

            $table->foreign('apiuser_id')->references('id')->on('apiuser')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('area')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('apiuser_position')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apiuser_info');
    }
}
