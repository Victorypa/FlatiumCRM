<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomStepServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_step_service', function (Blueprint $table) {
            $table->integer('room_step_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();

            $table->float('quantity')->nullable();
            $table->float('price')->nullable();

            $table->foreign('room_step_id')->references('id')->on('room_steps')->onDelete('cascade');
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
        Schema::dropIfExists('room_step_service');
    }
}
