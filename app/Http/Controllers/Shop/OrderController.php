<?php

namespace App\Http\Controllers\Shop;

use App\Models\Member;
use App\Models\Order;
use App\Models\OrderGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    //所有订单
    public function index()
    {
        $shopId=Auth::user()->id;
        $orders=Order::where('shop_id',$shopId)->paginate(5);
        return view('shop.order.index',compact('orders'));
    }

    //查看订单
    public function detail(Request $request,$id)
    {
        $order=Order::findOrFail($id);
        $orderGoods=OrderGood::where('order_id',$id)->get();
        return view('shop.order.detail',compact('order','orderGoods'));
    }

    //发货
    public function audit($id)
    {
        $order=Order::findOrFail($id);
        $order->status=2;
        $order->save();
        return back()->with("success","已发货");
    }

    //取消订单
    public function cancel(Request $request,$id)
    {
        $order=Order::findOrFail($id);
        $member=Member::findOrFail($order->user_id);
        $order->status=-1;
        if ($order->save()== true) {
            $member->money += $order->total;
            $member->save();
        }
        return back()->with("success","已取消订单");
    }

    //订单每日统计
    public function day(Request $request)
    {
        //每日
        $orderDay=Order::where('shop_id',Auth::user()->id)->where('status','>=','1')->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc')->limit(30);
        //总统计
        $orderSum=Order::where('shop_id',Auth::user()->id)->where('status','>=','1')->Select(DB::raw("SUM(total) AS money,count(*) AS count"))->limit(12);
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        //搜索条件
        if ($start !== null){
            $orderDay->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderDay->whereDate("created_at", "<=", $end);
        }

        //每日统计
        $orders=$orderDay->get();
        //总统计
        $sums=$orderSum->get();
        return view('shop.order.day',compact('orders','sums'));
    }

    //订单每月统计
    public function month(Request $request)
    {

        $orderMonth=Order::where('shop_id',Auth::user()->id)->where('status','>=','1')->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc')->limit(30);

        //总统计
        $orderSum=Order::where('shop_id',Auth::user()->id)->where('status','>=','1')->Select(DB::raw("SUM(total) AS money,count(*) AS count"))->limit(12);
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        //搜索条件
        if ($start !== null){
            $orderMonth->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderMonth->whereDate("created_at", "<=", $end);
        }

        //每月统计
        $orders=$orderMonth->get();
        //总统计
        $sums=$orderSum->get();
        return view('shop.order.month',compact('orders','sums'));
    }

    //菜品每日统计
    public function menuDay(Request $request)
    {
     $orderIds =Order::where('shop_id',Auth::user()->id)->pluck('id')->toArray();

     $orderDay=OrderGood::whereIn('order_id',$orderIds)->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date,goods_id,goods_name,sum(amount) as nums"))->groupBy("date")->groupBy("goods_id");

        //总销量
        $orderSum=OrderGood::whereIn('order_id',$orderIds)->Select(DB::raw("goods_id,goods_name,sum(amount) as nums"))->groupBy("goods_id");
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        $keywords=$request->input('keywords');
        //搜索条件
        if ($start !== null){
            $orderDay->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderDay->whereDate("created_at", "<=", $end);
        }
        if ($keywords!==null){
            $orderDay->where('goods_name','like',"%{$keywords}%");
        }

    $menus=$orderDay->get();
    //dd($menus);
        $orders=$orderSum->get();
    return view('shop.order.menuDay',compact('menus','orders'));
     }

     //菜品每月统计
    public function menuMonth(Request $request)
    {
        $orderIds =Order::where('shop_id',Auth::user()->id)->pluck('id')->toArray();
        //每日销量
        $orderMonth=OrderGood::whereIn('order_id',$orderIds)->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date,goods_id,goods_name,sum(amount) as nums"))->groupBy("date")->groupBy("goods_id");
        //总销量
        $orderSum=OrderGood::whereIn('order_id',$orderIds)->Select(DB::raw("goods_id,goods_name,sum(amount) as nums"))->groupBy("goods_id");
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        $keywords=$request->input('keywords');
        //搜索条件
        if ($start !== null){
            $orderMonth->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderMonth->whereDate("created_at", "<=", $end);
        }
        if ($keywords!==null){
            $orderMonth->where('goods_name','like',"%{$keywords}%");
        }
        $menus=$orderMonth->get();
        $orders=$orderSum->get();
        return view('shop.order.menuMonth',compact('menus','orders'));
    }
}
