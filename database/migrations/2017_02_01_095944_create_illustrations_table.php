<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllustrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('illustrations', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name')->nullable();
            $table->string('image');
            $table->tinyInteger('isFree')->default(1);
            $table->boolean('single')->nullable();
            $table->double('multiple')->nullable();
            $table->double('right')->nullable();
            //$table->string('keywords');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');

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
		Schema::drop('illustrations');
	}

}
