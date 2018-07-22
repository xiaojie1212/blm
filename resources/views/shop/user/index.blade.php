@extends('layouts.shop.default')
@section("title","店铺详情列表")
@section('content')
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>店铺类型</th>
            <th>店铺名称</th>
            <th>店铺图片</th>
            <th>评分</th>
            <th>是否品牌</th>
            <th>是否准时送达</th>
            <th>是否蜂鸟配送</th>
            <th>是否保</th>
            <th>是否票</th>
            <th>是否准</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>店铺公告</th>
            <th>优惠活动</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
            <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->shop_category->name}}</td>
                <td>{{$shop->shop_name}}</td>
                <td><img src="/uploads/{{$shop->img}}" width="50"></td>
                <td>{{$shop->rating}}</td>
                <td>{{$shop->brand===1?"是":"否"}}</td>
                <td>{{$shop->on_time===1?"是":"否"}}</td>
                <td>{{$shop->fengniao===1?"是":"否"}}</td>
                <td>{{$shop->bao===1?"是":"否"}}</td>
                <td>{{$shop->piao===1?"是":"否"}}</td>
                <td>{{$shop->zhun===1?"是":"否"}}</td>
                <td>{{$shop->start_send}}</td>
                <td>{{$shop->send_cost}}</td>
                <td>{{$shop->notice}}</td>
                <td>{{$shop->discount}}</td>
                <td>{{\App\Models\Shop::$statusArray[$shop->status]}}</td>
                <td>
                    <a href="{{route("user.edit",$shop->id)}}" class="btn btn-warning">编辑</a>
                </td>
            </tr>
    </table>

@endsection