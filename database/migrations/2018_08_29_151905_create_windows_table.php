<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->string('type');
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('quantity')->nullable();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('windows');
    }
}
