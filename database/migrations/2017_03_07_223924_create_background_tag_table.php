<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackgroundTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('background_tag', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('background_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('background_id')->references('id')->on('backgrounds');
            $table->foreign('tag_id')->references('id')->on('tags');

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
        Schema::dropIfExists('brackground_tag');
    }
}
