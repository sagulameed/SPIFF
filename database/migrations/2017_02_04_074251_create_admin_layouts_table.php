<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('canvas_thumbnail'); //png
            $table->string('canvas_image'); //jpg format
            $table->string('canvas_json');
            $table->tinyInteger('isTarget');
            $table->integer('adminDesign_id')->unsigned();
            $table->foreign('adminDesign_id')->references('id')->on('admin_designs');
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
        Schema::drop('admin_layouts');
    }
}
