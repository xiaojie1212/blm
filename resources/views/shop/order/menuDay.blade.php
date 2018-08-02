@extends('layouts.shop.default')
@section("title","菜品每日销量")
@section('content')

    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-right">
                    <input type="date" name="start" class="form-control" size="2"
                           value="{{request()->input('start')}}"> -
                    <input type="date" name="end" class="form-control" size="2"
                           value="{{request()->input('end')}}">
                    <div class="form-group">
                        <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="form-control" placeholder="菜品名称">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </nav>
    <h3 style="text-align: center">每月</h3>
    <table class="table table-bordered">
        <tr>
            <th>菜品ID</th>
            <th>日期</th>
            <th>菜品名</th>
            <th>总销量</th>
        </tr>
        @foreach($menus as $menu)
        <tr>
            <td>{{$menu->goods_id}}</td>
            <td>{{$menu->date}}</td>
            <td>{{$menu->goods_name}}</td>
            <td>{{$menu->nums}}</td>
        </tr>
        @endforeach
    </table>

    <h3 style="text-align: center">总统计</h3>
    <table class="table table-bordered">
        <tr>
            <th>菜品ID</th>
            <th>菜品名</th>
            <th>总销量</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->goods_id}}</td>
                <td>{{$order->goods_name}}</td>
                <td>{{$order->nums}}</td>
            </tr>
        @endforeach
    </table>
@endsection