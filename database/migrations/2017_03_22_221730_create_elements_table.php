<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('license',['single','multiple','right']);
            $table->string('type'); /*element type : picture, frame, grid etc*/
            $table->double('price');
            $table->integer('element_id');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');


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
        Schema::dropIfExists('elements');
    }
}
