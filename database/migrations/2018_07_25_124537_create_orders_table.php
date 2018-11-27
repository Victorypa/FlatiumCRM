<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('amo_id')->unsigned()->unique();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('manager_id')->index()->unsigned()->nullable();
            $table->longText('contract')->nullable();
            $table->longText('order_name')->nullable();
            $table->text('client_name')->nullable();
            $table->longText('price')->nullable();
            $table->longText('address')->nullable();
            $table->bigInteger('status')->default(0);
            $table->boolean('archived')->default(false);
            $table->timestamp('finish_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('manager_id')->references('id')->on('managers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
