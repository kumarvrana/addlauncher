<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelevisionspricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('televisionsprices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('television_id');
            $table->foreign('television_id')->references('id')->on('televisions');
            $table->string('price_key');
            $table->integer('price_value');
            $table->string('number_key');
            $table->integer('number_value');
            $table->string('duration_key');
            $table->integer('duration_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('televisionsprices');
    }
}
