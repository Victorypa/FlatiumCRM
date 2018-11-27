<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLengthWidthHeightAreaWallAreaPerimeterPriceAndDescriptionToExtraRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extra_rooms', function (Blueprint $table) {
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('area')->nullable();
            $table->float('wall_area')->nullable();
            $table->float('perimeter')->nullable();
            $table->float('price')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extra_rooms', function (Blueprint $table) {
            //
        });
    }
}
