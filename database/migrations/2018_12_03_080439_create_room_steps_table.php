<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_step_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('order_step_id')->references('id')->on('order_steps')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_steps');
    }
}
