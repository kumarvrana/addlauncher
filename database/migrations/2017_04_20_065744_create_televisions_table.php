<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('televisions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
            $table->integer('price');
            $table->string('location');
            $table->string('city');
            $table->string('state');
            $table->string('rank')->nullable();
            $table->string('landmark')->nullable();
            $table->string('genre');
            $table->integer('viewers')->nullable();
            $table->integer('display_options')->nullable();
            $table->longtext('description');
            $table->string('image');
            $table->longtext('references');
            $table->string('status');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('televisions');
    }
}
