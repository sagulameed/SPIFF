<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('license',['single','multiple','right']);
            $table->string('type'); /*element type : picture, frame, grid etc*/
            $table->double('price');
            $table->integer('element_id');
            $table->integer('design_id')->nullable();/*if license is single fill the design*/

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('purchase_elements');
    }
}
