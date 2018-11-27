<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_service', function (Blueprint $table) {
            $table->integer('room_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();
            $table->float('quantity')->nullable();
            $table->float('price')->nullable();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services');

            $table->primary(['room_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_service');
    }
}
