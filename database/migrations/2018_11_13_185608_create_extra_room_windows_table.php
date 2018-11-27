<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraRoomWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_room_windows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('extra_room_id')->unsigned()->index();
            $table->string('type');
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('quantity')->nullable();
            $table->timestamps();

            $table->foreign('extra_room_id')->references('id')->on('extra_rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_room_windows');
    }
}
