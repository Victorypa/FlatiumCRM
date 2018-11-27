<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeginAtAndFinishAtToExtraOrderActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extra_order_acts', function (Blueprint $table) {
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('finish_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extra_order_acts', function (Blueprint $table) {
            $table->dropColumn(['begin_at', 'finish_at']);
        });
    }
}
