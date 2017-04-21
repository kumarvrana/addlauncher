<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalsettings', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('sitename');
            $table->longText('tagline')->nullable();
            $table->longText('logo');
            $table->string('firstemail');
            $table->string('secondemail')->nullable();
            $table->integer('firstphone');
            $table->integer('secondphone')->nullable();
            $table->longText('address');
            $table->longText('facebook')->nullable();
            $table->longText('twitter')->nullable();
            $table->longText('linkedin')->nullable();
            $table->longText('google')->nullable();
            $table->longText('youtube')->nullable();
            $table->longText('instagram')->nullable();
            $table->longText('reddit')->nullable();
            $table->longText('rss')->nullable();
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
        Schema::dropIfExists('generalsettings');
    }
}
