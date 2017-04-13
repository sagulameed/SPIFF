<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllustrationTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illustration_tag', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('illustration_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('illustration_id')->references('id')->on('illustrations');
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
        Schema::dropIfExists('illustration_tag');
    }
}
