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
            $table->string('inst_id', 60);
            $table->enum('inst_type', ['IdP', 'SP', 'IdP+SP']);
            $table->enum('inst_stage', ['0', '1']);
            /*key for inst_names*/
            $table->unsignedInteger('inst_name_id');

            $table->string('address_street');
            $table->string('address_city');
            $table->string('latitude', 15);
            $table->string('longitude', 15);

            $table->string('info_URL_en');
            $table->string('info_URL_ru')->nullable();
            $table->string('policy_URL_en');
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
