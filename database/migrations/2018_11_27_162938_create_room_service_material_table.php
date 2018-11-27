<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomServiceMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_service_material', function (Blueprint $table) {
            $table->integer('room_service_id')->unsigned()->index();
            $table->integer('material_id')->unsigned()->index();
            $table->float('rate')->nullable();

            $table->foreign('room_service_id')->references('id')->on('room_services')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

            $table->primary(['room_service_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_service_material');
    }
}
