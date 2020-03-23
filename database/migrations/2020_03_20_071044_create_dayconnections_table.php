<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dayconnections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('proxy');
            $table->string('realm');
            $table->date('creationDate');
            $table->string('user_unique');
            $table->dateTime('max_time_conn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dayconnections');
    }
}
