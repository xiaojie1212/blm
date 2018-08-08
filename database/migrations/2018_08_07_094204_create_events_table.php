<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('content')->comment('内容');
            $table->integer('start_time')->comment('开始时间');
            $table->integer('end_time')->comment('结束时间');
            $table->integer('prize_time')->comment('开奖时间');
            $table->integer('num')->comment('报名人数显限制');
            $table->boolean('is_prize')->comment('是否开奖');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
