<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForTransfert extends Migration
{

    public function up()
    {
        /*Schema::create('transferts', function (Blueprint $table) {
            $table->increments('id_transfert');
            $table->integer('id_user');

            $table->integer('id_magasin_source');
            $table->integer('user_id');
            $table->string('code');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('code');
        });*/
    }


    public function down()
    {
        //
    }
}
