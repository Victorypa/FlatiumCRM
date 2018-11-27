<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomFinishedServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_finished_service', function (Blueprint $table) {
            $table->integer('finished_room_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();

            $table->float('quantity')->nullable();
            $table->float('price')->nullable();

            $table->foreign('finished_room_id')->references('id')->on('finished_rooms')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_finished_service');
    }
}
