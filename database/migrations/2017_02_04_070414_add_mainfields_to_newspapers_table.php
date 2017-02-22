<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainfieldsToNewspapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newspapers', function (Blueprint $table) {
            $table->string('title');
            $table->integer('price')->nullable();
            $table->string('location');
            $table->string('city');
            $table->string('state');
            $table->string('rank')->nullable();
            $table->string('landmark')->nullable();
            $table->longtext('description');
            $table->string('image');
            $table->longtext('references');
            $table->string('status');
            $table->integer('circulations')->nullable();
            $table->string('language')->nullable();
            $table->string('general_options')->nullable();
            $table->string('other_options')->nullable();
            $table->string('classified_options')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newspapers', function (Blueprint $table) {
            //
        });
    }
}
