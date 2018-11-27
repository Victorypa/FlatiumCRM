<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material_unit_id')->unsigned()->index();
            $table->text('name')->nullable();
            $table->text('number')->nullable();
            $table->float('price')->nullable();
            $table->float('quantity')->nullable();
            $table->float('univalence')->nullable();
            $table->boolean('can_be_deleted')->default(false);

            $table->foreign('material_unit_id')->references('id')->on('material_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
