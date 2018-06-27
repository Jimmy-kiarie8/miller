<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeriveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deriveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('grower_name');
            $table->string('code');
            $table->string('coffee_types');
            $table->integer('no_of_bags');
            $table->string('weight');
            $table->string('vihicle_reg');
            $table->string('pammit_no');
            $table->string('weighing_bridge');
            $table->string('clerks_name');
            $table->string('grower_rep');
            $table->string('units');
            $table->string('society');
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
        Schema::dropIfExists('deriveries');
    }
}
