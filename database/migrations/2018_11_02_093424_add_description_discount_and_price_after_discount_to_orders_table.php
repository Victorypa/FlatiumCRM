<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionDiscountAndPriceAfterDiscountToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->float('original_price')->nullable();
            $table->float('discount')->nullable();
            $table->float('markup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'description', 'discount',
                'markup', 'original_price'
            ]);
        });
    }
}
