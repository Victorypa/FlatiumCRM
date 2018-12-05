<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceTypeIdAndServiceUnitIdToRoomStepService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_step_service', function (Blueprint $table) {
            $table->integer('service_type_id')->unsigned()->nullable();
            $table->integer('service_unit_id')->unsigned()->nullable();

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
        Schema::table('room_step_service', function (Blueprint $table) {
            $table->dropColumn(['service_type_id', 'service_unit_id']);
        });
    }
}
