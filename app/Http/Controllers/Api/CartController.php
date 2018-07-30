<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends BaseController
{
    //添加到购物车
    public function add(Request $request)
    {
        //接收参数
        $userId=$request->input('user_id');
        $goods=$request->input('goodsList');
        $goodsCount=$request->input('goodsCount');
        //清除
        Cart::where("user_id",$userId)->delete();

        //循环取值赋值
        foreach ($goods as $k=>$good){
            $data=[
                'user_id' =>$userId,
                'goods_id' =>$good,
                'amount' =>$goodsCount[$k]
            ];
            Cart::create($data);
        }
        return [
            "status"=>"true",
            "message"=>"添加成功"
        ];
    }

    //获取购物车里的商品
    public function list(Request $request)
    {
        $userId=$request->input('user_id');
        $carts=Cart::where('user_id',$userId)->get();
        //商品集合
        $goodsList=[];
        //总价初始化
        $totalCost=0;

        //循环赋值到goodsList中
        foreach ($carts as $k=>$cart){
            $goods=Menu::where('id',$cart->goods_id)->first(['goods_img','goods_name','goods_price']);
            $goods->goods_id="{$cart->goods_id}";
            $goods->amount = $cart->amount;
            //计算总价格
            $totalCost += $goods->amount * $goods->goods_price;
            //追加
            $goodsList[] = $goods;
        }
        return [
            'goods_list' => $goodsList,
            'totalCost' => $totalCost
        ];
    }
}
