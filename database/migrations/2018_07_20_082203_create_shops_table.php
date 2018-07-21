<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_category_id')->comment('店铺分类ID');
            $table->string('name')->comment('店铺名称');
            $table->string('img')->comment('店铺图片');
            $table->float('rating')->comment('评分');
            $table->boolean('brand')->comment('是否品牌');
            $table->boolean('on_time')->comment('是否准时送达');
            $table->boolean('fengniao')->comment('是否蜂鸟配送');
            $table->boolean('bao')->comment('是否保');
            $table->boolean('piao')->comment('是否票');
            $table->boolean('zhun')->comment('是否准');
            $table->decimal('start_send')->comment('起送金额');
            $table->decimal('send_cost')->comment('配送费');
            $table->string('notice')->comment('店铺公告');
            $table->string('discount')->comment('优惠信息');
            $table->integer('status')->comment('状态');
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
        Schema::dropIfExists('shops');
    }
}
