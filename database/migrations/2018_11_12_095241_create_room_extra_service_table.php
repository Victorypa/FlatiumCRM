<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomExtraServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_extra_service', function (Blueprint $table) {
            $table->integer('extra_room_id')->unsigned()->index();
            $table->integer('service_id')->unsigned()->index();

            $table->float('quantity')->nullable();
            $table->float('price')->nullable();

            $table->foreign('extra_room_id')->references('id')->on('extra_rooms')->onDelete('cascade');
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
        Schema::dropIfExists('room_extra_service');
    }
}
