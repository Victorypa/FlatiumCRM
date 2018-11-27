<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('finished_order_act_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('finished_order_act_id')->references('id')->on('finished_order_acts')->onDelete('cascade');
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
        Schema::dropIfExists('finished_rooms');
    }
}
