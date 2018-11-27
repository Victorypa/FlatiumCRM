<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomWorkRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_work', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->integer('work_id')->unsigned()->index();
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('finish_at')->nullable();

            $table->timestamp('begin_at_in_fact')->nullable();
            $table->timestamp('finish_at_in_fact')->nullable();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('work_id')->references('id')->on('works');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_work');
    }
}
