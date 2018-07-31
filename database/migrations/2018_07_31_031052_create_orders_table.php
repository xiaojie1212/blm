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
            $table->unsignedInteger('user_id')->comment("用户id");
            $table->unsignedInteger('shop_id')->comment("商铺id");
            $table->string('sn')->comment("订单编号");
            $table->string('province')->comment("省");
            $table->string('city')->comment("市");
            $table->string('county')->comment("区");
            $table->string('address')->comment("详细地址");
            $table->string('tel')->comment("电话");
            $table->string('name')->comment("姓名");
            $table->decimal('total')->comment("总价");
            $table->boolean('status')->comment("状态");
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
        Schema::dropIfExists('orders');
    }
}
