<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainfieldsToBusstopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('busstops', function (Blueprint $table) {
            $table->string('title');
            $table->integer('price');
            $table->string('location');
            $table->string('city');
            $table->string('state');
            $table->string('rank')->nullable();
            $table->string('landmark')->nullable();
            $table->longtext('description');
            $table->string('image');
            $table->longtext('references')->nullable();
            $table->string('status');
            $table->string('display_options')->nullable();
            $table->string('light_option')->nullable();
            $table->string('stopinnumber')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('busstops', function (Blueprint $table) {
            //
        });
    }
}
