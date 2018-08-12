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

use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;
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
                //$user = User::where("id", $shopId)->first();
                //Mail::to($user)->send(new OrderShipped($order));
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

    //微信支付
    public function wxPay(Request $request)
    {
        //得到订单
        $order=Order::find($request->input('id'));


        //创建操作微信的对象
        $app = new Application(config('wechat'));
        //得到支付对象
        $payment = $app->payment;
        //订单配置
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => '饱了没',
            'detail'           => '饱了没点餐详情',
            'out_trade_no'     => $order->sn,
            'total_fee'        => 1, // 单位：分 $order->total*100
            'notify_url'       => '/api/order/ok', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        //订单生成
        $order = new \EasyWeChat\Payment\Order($attributes);
        //统一下单
        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            //取出预支付链接
            $payUrl=  $result->code_url;
            //把支付链接生成二维码
            $qrCode = new QrCode($payUrl);
            header('Content-Type: '.$qrCode->getContentType());
            echo $qrCode->writeString();
            exit;
        }
    }

    //状态
    public function status(Request $request)
    {
        return [
            'status'=>Order::find($request->input('id'))->status
        ];
    }

    //微信异步通知
    public function ok(){

        //创建操作微信的对象
        $app = new Application(config('wechat'));
        //处理微信通知信息
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            //  $order = 查询订单($notify->out_trade_no);
            $order=Order::where("sn",$notify->out_trade_no)->first();

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!==0) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                // $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 1;//更新订单状态
            }
            $order->save(); // 保存订单
            return true; // 返回处理完成
        });

        return $response;
    }
}
