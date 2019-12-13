<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.  .
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('inst_id', 60)->nullable();
            $table->enum('inst_type', ['IdP', 'SP', 'IdP+SP'])->default('IdP+SP');
            $table->enum('venue_type', ['3,3', '2,8', '7,3'])->default('3,3');
            $table->enum('inst_stage', ['0', '1'])->default('1');
            /*key for inst_names*/
            $table->unsignedInteger('inst_name_id');

            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('latitude', 150)->nullable();
            $table->string('longitude', 150)->nullable();

            $table->string('info_URL_en')->default('https://www.eduroam.ru');
            $table->string('info_URL_ru')->nullable();
            $table->string('policy_URL_en')->default('https://www.eduroam.ru');
            $table->string('policy_URL_ru')->nullable();

            $table->unsignedInteger('creator_id');




        });

        Schema::table('institutions', function($table) {
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('inst_name_id')->references('id')->on('instnames')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions');
    }

}
