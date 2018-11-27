<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualServiceMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_service_material', function (Blueprint $table) {
            $table->integer('service_id')->unsigned()->index();
            $table->integer('material_id')->unsigned()->index();
            $table->float('rate')->nullable();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

            $table->primary(['service_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actual_service_material');
    }
}
