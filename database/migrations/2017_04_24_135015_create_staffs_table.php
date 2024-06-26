<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('bot_id')->index();
            $table->integer('xatid');
            $table->string('regname');
            $table->unsignedInteger('minrank_id');
            $table->timestamps();
            $table->foreign('bot_id')->references('id')->on('bots');
            $table->foreign('minrank_id')->references('id')->on('minranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staffs');
    }
}
