@extends('layouts.shop.default')
@section("title","每月订单")
@section('content')

    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-right">
                    {{--<div class="form-group">
                        <select name="menu_id" class="form-control">
                            <option value="">请选择分类</option>

                        </select>
                    </div>--}}
                    <input type="date" name="start" class="form-control" size="2"
                           value="{{request()->input('start')}}"> -
                    <input type="date" name="end" class="form-control" size="2"
                           value="{{request()->input('end')}}">
                    {{--<div class="form-group">
                        <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="form-control" placeholder="菜品名称">
                    </div>--}}
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </nav>
    <h3 style="text-align: center">每月</h3>
    <table class="table table-bordered">
        <tr>
            <th>月份</th>
            <th>订单总量</th>
            <th>总金额</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->day}}</td>
            <td>{{$order->count}}</td>
            <td>{{$order->money}}</td>
        </tr>
        @endforeach
    </table>

    <h3 style="text-align: center">总统计</h3>
    <table class="table table-bordered">
        <tr>
            <th>总金额</th>
            <th>总订单量</th>
        </tr>
        @foreach($sums as $sum)
            <tr>
                <td>{{$sum->money}}</td>
                <td>{{$sum->count}}</td>
            </tr>
        @endforeach
    </table>
@endsection