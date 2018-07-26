@extends('layouts.admin.default')
@section("title","店铺详情列表")
@section('content')
    <a href="{{route("shop.reg")}}" class="btn btn-info">添加</a>
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>店铺类型</th>
            <th>店铺名称</th>
            <th>店铺图片</th>
            <th>评分</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($shops as $shop)
            <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->shop_category->name}}</td>
                <td>{{$shop->shop_name}}</td>
                <td><img src="{{$shop->img}}" width="50"></td>
                <td>{{$shop->rating}}</td>
                <td>{{$shop->start_send}}</td>
                <td>{{$shop->send_cost}}</td>
                <td>{{\App\Models\Shop::$statusArray[$shop->status]}}</td>
                <td>
                    <a href="{{route("shop.edit",$shop->id)}}" class="btn btn-warning">编辑</a>
                    <a href="{{route("shop.del",$shop->id)}}" onclick="return confirm('是否连着账号一起删除？')" class="btn btn-danger">删除</a>
                    @if($shop->status===0)
                        <a href="{{route('shop.audit',$shop->id)}}" class="btn btn-info">审核</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
{{$shops->links()}}
@endsection