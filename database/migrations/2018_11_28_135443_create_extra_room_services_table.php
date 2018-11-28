<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraRoomServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_room_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('extra_room_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('service_type_id')->unsigned()->nullable();
            $table->integer('service_unit_id')->unsigned()->nullable();
            $table->float('quantity')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();

            $table->foreign('extra_room_id')->references('id')->on('extra_rooms')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('service_unit_id')->references('id')->on('units')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_room_services');
    }
}
