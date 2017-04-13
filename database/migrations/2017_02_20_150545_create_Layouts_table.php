<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('layouts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->string('canvas_thumbnail'); //png format
            $table->string('canvas_image'); //jpg format
            $table->string('canvas_json');
            $table->tinyInteger('isTarget');

            $table->integer('design_id')->unsigned();
            $table->foreign('design_id')->references('id')->on('designs');

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
		Schema::drop('layouts');
	}

}
