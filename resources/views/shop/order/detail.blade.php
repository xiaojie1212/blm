@extends('layouts.shop.default')
@section("title","订单详情")
@section('content')


    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>订单号</th>
            <th>地址详情</th>
            <th>联系电话</th>
            <th>联系人</th>
            <th>订单价格</th>
            <th>订单状态</th>
        </tr>
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->sn}}</td>
            <td>{{$order->city.$order->area.$order->detail_address}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->total}}</td>
            <td>{{\App\Models\Order::$orderStatus[$order->status]}}</td>
        </tr>
        <tr>
            <th>商品ID</th>
            <th>商品销量</th>
            <th>商品名称</th>
            <th>商品图片</th>
            <th>总价格</th>
        </tr>
        @foreach($orderGoods as $orderGood)
        <tr>
            <td>{{$orderGood->goods_id}}</td>
            <td>{{$orderGood->amount}}</td>
            <td>{{$orderGood->goods_name}}</td>
            <td><img src="{{$orderGood->goods_img}}" style="width:60px"></td>
            <td>{{$orderGood->amount * $orderGood->goods_price}}</td>
        </tr>
        @endforeach
    </table>

@endsection