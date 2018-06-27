<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milleds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('code');
            $table->string('grower_name');
            $table->text('remarks');
            $table->integer('no_of_bags');
            $table->integer('no_of_pockets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milleds');
    }
}
