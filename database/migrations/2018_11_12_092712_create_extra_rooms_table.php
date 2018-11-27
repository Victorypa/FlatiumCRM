<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('extra_order_act_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('extra_order_act_id')->references('id')->on('extra_order_acts')->onDelete('cascade');
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
        Schema::dropIfExists('extra_rooms');
    }
}
