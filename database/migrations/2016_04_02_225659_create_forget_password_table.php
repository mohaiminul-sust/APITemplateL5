<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForgetPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forget_password', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('password_actual');
            $table->integer('apiuser_id')->unsigned();
            $table->integer('status')->nullable();
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
        Schema::drop('forget_password');
    }
}
