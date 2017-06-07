<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagazinepricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazineprices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('magazine_id');
            $table->string('price_key')->nullable();
            $table->integer('price_value')->nullable();
            $table->string('number_key')->nullable();
            $table->integer('number_value')->nullable();
            $table->string('duration_key')->nullable();
            $table->integer('duration_value')->nullable();
            $table->string('option_type')->nullable();
            $table->string('ad_code')->nullable();
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
        Schema::dropIfExists('magazineprices');
    }
}
