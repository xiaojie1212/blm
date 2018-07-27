<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\MenuCategories;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //提供店铺列表
    public function list(Request $request)
    {
        $keyword=$request->input('keyword');

        $shops=Shop::where('status',1)->where('shop_name','like',"%$keyword%")->get();
        //距离跟分钟
        foreach ($shops as $shop) {
            $shop->distance = rand(500, 3000);
            $shop->estimate_time = $shop->distance / 80;
        }
        return $shops;
    }

    //提供具体店铺信息
    public function index(Request $request)
    {
        //店铺的ID
        $id = $request->input('id');
        //取出当前店铺信息
        $shop = Shop::findOrFail($id);
        //距离跟分钟
        $shop->distance = rand(500, 3000);
        $shop->estimate_time = $shop->distance / 80;
        //添加评论
        $shop->evaluate = [
            [
                "user_id" => 12344,
                "username" => "w******k",
                "user_img" => "http://www.homework.com/images/slider-pic4.jpeg",
                "time" => "2017-2-22",
                "evaluate_code" => 1,
                "send_time" => 30,
                "evaluate_details" => "不怎么好吃"]
        ];
        //取出分类
        $cates=MenuCategories::where("shop_id",$id)->get();

        //循环分类
        $manus=Menu::all();
        foreach ($cates as $cate){
            $arr=[];
            foreach ($manus as $manu){
                if ($cate->id === $manu->category_id){
                    array_push($arr,$manu);
                }
                $cate->goods_list=$arr;
            }
        }
        $shop->commodity=$cates;

        return $shop;
    }
}
