<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFramesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('frames', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('frame_name');
            $table->tinyInteger('isFree')->default(1);
            $table->double('single')->nullable();
            $table->double('multiple')->nullable();
            $table->double('right')->nullable();
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
		Schema::drop('frames');
	}

}
