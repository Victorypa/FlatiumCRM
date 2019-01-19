<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('finance_id')->unsigned()->index();
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('finance_id')->references('id')->on('finances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_files');
    }
}
