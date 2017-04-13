<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->double('total'); /*total of sum the other total*/
            $table->double('totalElements'); /*total of recources indluded in the canvas*/
            $table->double('totalDelivery'); /*total of shipping pieces*/
            $table->double('totalPieces');/*total of pieces ordered*/
            $table->integer('numPieces'); /*num pieces ordered*/
            $table->longText('json_info'); //Json which contains all the payment and order info
            $table->string('ordered_at')->nullable(); //date with timezone
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('orders');
    }
}
