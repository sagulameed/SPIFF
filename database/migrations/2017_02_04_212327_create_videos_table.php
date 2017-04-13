<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',80);
            $table->string('subtitle',150);
            $table->mediumText('description');
            $table->string('thumbnail');
            $table->string('video');
            $table->string('duration');
            $table->bigInteger('numViews')->default(0);
            $table->bigInteger('rate')->default(0);
            $table->bigInteger('numVotes')->default(0);

            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

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
        Schema::drop('videos');
    }
}
