<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraRoomServiceMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_room_service_material', function (Blueprint $table) {
            $table->integer('extra_room_service_id')->unsigned()->index();
            $table->integer('material_id')->unsigned()->index();
            $table->float('rate')->nullable();

            $table->foreign('extra_room_service_id')->references('id')->on('extra_room_services')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

            $table->primary(['extra_room_service_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_room_service_material');
    }
}
