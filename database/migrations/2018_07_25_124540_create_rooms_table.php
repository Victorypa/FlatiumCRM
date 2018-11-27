<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index()->unsigned();
            $table->integer('room_type_id')->index()->unsigned();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('area')->nullable();
            $table->float('wall_area')->nullable();
            $table->float('perimeter')->nullable();
            $table->float('price')->nullable();
            $table->timestamp('finish_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
