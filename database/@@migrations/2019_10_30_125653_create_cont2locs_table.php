<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCont2locsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont2locs', function (Blueprint $table) {
            $table->Increments('id');
            $table->timestamps();
            $table->unsignedInteger('cont_id');
            $table->unsignedInteger('loc_id');

        });

        Schema::table('cont2locs', function($table) {
            $table->foreign('cont_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('loc_id')->references('id')->on('outlets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cont2locs');
    }
}
