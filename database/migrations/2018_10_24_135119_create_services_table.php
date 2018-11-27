<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_type_id')->unsigned()->index();
            $table->integer('unit_id')->unsigned()->index();
            $table->string('name');
            $table->float('price');
            $table->boolean('can_be_deleted')->default(false);

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('service_type_id')->references('id')->on('service_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
