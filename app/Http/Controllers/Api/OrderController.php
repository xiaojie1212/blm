<?php

namespace App\Http\Controllers\Api;

use App\Mail\OrderShipped;
use App\Models\Addresses;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mrgoon\AliSms\AliSms;

class OrderController extends BaseController
{
    //生成订单
    public function add(Request $request)
    {

            //接收参数
            $addressId=$request->input('address_id');
           // dd($addressId);
            $userId=$request->input('user_id');

            //找地址
            $addresses=Addresses::find($addressId);
            //追加ID
            $data['user_id']=$userId;
            $cart=Cart::where('user_id',$userId)->first();
           // dd(Menu::find($cart->goods_id)->shop_id);
            //到菜品表找shop_id
            $shopId=Menu::find($cart->goods_id)->shop_id;
            $data['shop_id']=$shopId;
            //订单生成
            $data['sn']=date("YmdHis").rand(1000,9999);
            //地址信息
            $data['province'] = $addresses->province;
            $data['city'] = $addresses->city;
            $data['area'] = $addresses->area;
            $data['detail_address'] = $addresses->detail_address;
            $data['tel'] = $addresses->tel;
            $data['name'] = $addresses->name;
            //总价
            $total=0;
            $carts=Cart::where("user_id",$userId)->get();
            foreach ($carts as $k=>$cart){
                $good=Menu::where('id',$cart->goods_id)->first();

                $total +=$cart->amount * $good->goods_price;
            }
            $data['total']=$total;
            //状态
            $data['status']=0;
            //创建订单

            //开启事务
            DB::beginTransaction();
            try{
                $order=Order::create($data);
                //订单商品 orderGood
                foreach ($carts as $k=>$cart){
                    $good = Menu::find($cart->goods_id);
                    //构造数据
                    $goods['order_id'] = $order->id;
                    $goods['goods_id'] = $cart->goods_id;
                    $goods['amount'] = $cart->amount;
                    $goods['goods_name'] = $good->goods_name;
                    $goods['goods_img'] = $good->goods_img;
                    $goods['goods_price'] = $good->goods_price;
                    //数据入库
                    OrderGood::create($goods);
                }
                $user = User::where("id", $shopId)->first();
                Mail::to($user)->send(new OrderShipped($order));
                //提交
                DB::commit();
            }catch (QueryException $exception){
                //回滚
                DB::rollBack();
                //返回数据
                return [
                    "status" => "false",
                    "message" => $exception->getMessage(),
                ];
    }


            return [
                "status" => "true",
                "message" => "添加成功",
                "order_id" => $order->id
            ];

    }
    //获取指定订单
    public function order(Request $request)
    {
        $order=Order::find($request->input('id'));
        $shops=Shop::find($order->shop_id);
        $data['id'] = $order->id;
        $data['order_code'] = $order->sn;
        $data['order_birth_time'] = (string)$order->created_at;
        $data['order_status'] = $order->order_status;
        $data['shop_id'] = $order->shop_id;
        $data['shop_name'] = $shops['shop_name'];
        $data['shop_img'] = $shops['shop_img'];
        $data['order_price'] = $order->total;
        $data['order_address'] = $order->province.$order->city.$order->area.$order->detail_address;

        $data['goods_list'] = $order->goods;
        return $data;
    }
    //支付
    public function pay(Request $request)
    {
        $order = Order::find($request->post('id'));
        //得到用户
        $member = Member::find($order->user_id);

        //判断钱够不
        if ($order->total > $member->money) {
            return [
                'status' => 'false',
                "message" => "穷比没钱还想买东西？"
            ];
        }
        //减金额
        $member->money = $member->money - $order->total;
        $member->save();
        //更改订单状态
        $order->status = 1;
        $order->save();

        $config = [
            'access_key' => 'LTAIrGYffYL2khhY',
            'access_secret' => 'J9LzDSH0R0WzbICjKzmV257xZmcP26',
            'sign_name' => '杜连杰',
        ];

        $aliSms = new AliSms();$aliSms->sendSms($member->tel, 'SMS_141635136', ['product'=> $member->username], $config);
        return [
            'status' => 'true',
            "message" => "支付成功"
        ];
    }
    //订单列表
    public function list(Request $request)
    {
        $userId=$request->input('user_id');
        $orders=Order::where("user_id",$userId)->get();

        foreach ($orders as $k=>$order){
            $shops=Shop::find($order->shop_id);

            $data['id'] = $order->id;
            $data['order_code'] = $order->sn;
            $data['order_birth_time'] = (string)$order->created_at;
            $data['order_status'] = $order->order_status;
            $data['shop_id'] = (string)$order->shop_id;
            $data['shop_name'] = $shops['shop_name'];
            $data['shop_img'] = $shops['shop_img'];
            $data['order_price'] = $order->total;
            $data['order_address'] = $order->provence . $order->city . $order->area . $order->detail_address;

            $data['goods_list'] = $order->goods;

            $lists[]=$data;
        }

        return $lists;
    }
}
