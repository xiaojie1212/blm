@extends('layouts.admin.default')
@section("title","订单列表")
@section('content')

    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <select name="id" class="form-control">
                            <option value="">请选择商户</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}" @if(request()->input("id")==$user->id) selected @endif>{{$user->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <input type="date" name="start" class="form-control" size="2"
                           value="{{request()->input('start')}}"> -
                    <input type="date" name="end" class="form-control" size="2"
                           value="{{request()->input('end')}}">

                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </nav>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>订单号</th>
            <th>地址详情</th>
            <th>联系电话</th>
            <th>联系人</th>
            <th>订单价格</th>
            <th>订单时间</th>
            <th>订单状态</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->sn}}</td>
            <td>{{$order->city.$order->area.$order->detail_address}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->total}}</td>
            <td>{{$order->created_at}}</td>
            <td>{{\App\Models\Order::$orderStatus[$order->status]}}</td>
        </tr>
        @endforeach
    </table>
{{$orders->appends($arr)->links()}}
@endsection