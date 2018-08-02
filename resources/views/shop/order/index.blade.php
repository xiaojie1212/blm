@extends('layouts.shop.default')
@section("title","订单列表")
@section('content')

   {{-- <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-right">
                    --}}{{--<div class="form-group">
                        <select name="menu_id" class="form-control">
                            <option value="">请选择分类</option>

                        </select>
                    </div>--}}{{--
                    <input type="date" name="start" class="form-control" size="2"
                           value="{{request()->input('start')}}"> -
                    <input type="date" name="end" class="form-control" size="2"
                           value="{{request()->input('end')}}">
                    --}}{{--<div class="form-group">
                        <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="form-control" placeholder="菜品名称">
                    </div>--}}{{--
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </nav>--}}

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>订单号</th>
            <th>地址详情</th>
            <th>联系电话</th>
            <th>联系人</th>
            <th>订单价格</th>
            <th>订单状态</th>
            <th>操作</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->sn}}</td>
            <td>{{$order->city.$order->area.$order->detail_address}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->total}}</td>
            <td>{{\App\Models\Order::$orderStatus[$order->status]}}</td>
                <td>
                    <a href="{{route("order.detail",$order->id)}}" class="btn btn-info">查看</a>
                    @if($order->status == 1)
                    <a href="{{route('order.audit',$order->id)}}" class="btn btn-success">发货</a>
                    @endif
                    @if($order->status == 0)
                    <a href="{{route('order.cancel',$order->id)}}" class="btn btn-danger">取消订单</a>
                    @endif
                </td>
        </tr>
        @endforeach
    </table>
    {{$orders->links()}}
@endsection