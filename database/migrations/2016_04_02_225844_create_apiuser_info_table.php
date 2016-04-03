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
            $table->timestamps();

            $table->foreign('apiuser_id')->references('id')->on('apiuser')->onUpdate('cascade')->onDelete('cascade');
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
