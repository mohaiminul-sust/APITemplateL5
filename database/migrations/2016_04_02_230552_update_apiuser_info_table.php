<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApiuserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiuser_info', function (Blueprint $table) {
            $table->boolean('activation')->default('0');
            $table->string('activation_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apiuser_info', function (Blueprint $table) {
            $table->dropColumn('activation');
            $table->dropColumn('activation_key');
        });
    }
}
