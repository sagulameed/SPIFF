<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackgroundsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('backgrounds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('background_name');
            $table->tinyInteger('isFree')->default(1);
			$table->boolean('single')->nullable();
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
		Schema::drop('backgrounds');
	}

}
