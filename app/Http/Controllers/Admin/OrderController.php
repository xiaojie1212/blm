<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderGood;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    //所有
    public function index(Request $request)
    {
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        $id=$request->input('id');

        $users=\App\Models\User::all();
        $query=Order::orderBy('created_at');

        //搜索条件
        if ($id !== null){
            $query->where('shop_id','=',$id);
        }
        if ($start !== null){
            $query->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        $orders=$query->paginate(5);
        $arr=$request->query();
        return view('admin.order.index',compact('orders','users','arr'));
    }

    //订单每天统计
    public function day(Request $request)
    {

        //接收搜索参数
        $users=\App\Models\User::all();

        $start=$request->input('start');
        $end=$request->input('end');
        $id=$request->input('id');

        $orderDay=Order::orderBy('id');
        //每日
        $orderDay=$orderDay->where('status','>=','1')->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc');
        //搜索条件
        if ($start !== null){
            $orderDay->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderDay->whereDate("created_at", "<=", $end);
        }
        $shopId="";
        //搜索条件
        if ($id !== null){
            $orderDay->where('shop_id','=',$id);
            $shopId=Order::where('shop_id',$id)->first()->shop_id;
        }

        //每日统计
        $orders=$orderDay->get();

        return view('admin.order.day',compact('orders','users','shopId','id'));
    }

    //订单每月统计
    public function month(Request $request)
    {

        //接收搜索参数
        $users=\App\Models\User::all();

        $start=$request->input('start');
        $end=$request->input('end');
        $id=$request->input('id');

        $orderMonth=Order::orderBy('id');
        //每日
        $orderMonth=$orderMonth->where('status','>=','1')->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc');
        //搜索条件
        if ($start !== null){
            $orderMonth->whereDate('created_at','>=',$start);
        }
        if ($end !== null) {
            $orderMonth->whereDate("created_at", "<=", $end);
        }
        $shopId="";
        //搜索条件
        if ($id !== null){
            $orderMonth->where('shop_id','=',$id);
            $shopId=Order::where('shop_id',$id)->first()->shop_id;
        }
        //每日统计
        $orders=$orderMonth->get();

        return view('admin.order.day',compact('orders','users','shopId','id'));
    }

    //菜单每日统计
    public function menuDay(Request $request)
    {
        $users=User::all();
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        $keywords=$request->input('keywords');
        $id=$request->input('id');
        //显示所有
        $orderDay=OrderGood::orderBy('created_at');
        //店铺搜索
        $shopId="";
        if ($id !== null){
            //得到order_id
            $orderIds =Order::where('shop_id',$id)->pluck('id')->toArray();

            $orderDay->whereIn('order_id',$orderIds);
            $shopId=Order::where('shop_id',$id)->first()->shop_id;
        }

        $orderDay->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date,goods_id,goods_name,sum(amount) as nums"))->groupBy("date")->groupBy("goods_id");
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

        return view('admin.order.menuDay',compact('menus','users','shopId','id'));
    }

    //菜单每月统计
    public function menuMonth(Request $request)
    {
        $users=User::all();
        //接收搜索参数
        $start=$request->input('start');
        $end=$request->input('end');
        $keywords=$request->input('keywords');
        $id=$request->input('id');
        //显示所有
        $orderDay=OrderGood::orderBy('created_at');
        //店铺搜索
        $shopId="";
        if ($id !== null){
            //得到order_id
            $orderIds =Order::where('shop_id',$id)->pluck('id')->toArray();

            $orderDay->whereIn('order_id',$orderIds);
            $shopId=Order::where('shop_id',$id)->first()->shop_id;
        }

        $orderDay->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date,goods_id,goods_name,sum(amount) as nums"))->groupBy("date")->groupBy("goods_id");
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

        return view('admin.order.menuDay',compact('menus','users','shopId','id'));
    }
}
