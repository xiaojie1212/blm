@extends('layouts.admin.default')
@section("title","每日订单")
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
        @if($shopId == "")
    <h3 style="text-align: center">所有商家每日订单总量统计</h3>
         @elseif($shopId == $id)
        <h3 style="text-align: center">所搜索的商家每日订单统计</h3>
        @endif
    <table class="table table-bordered">
        <tr>
            <th>日期</th>
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

   {{-- <h3 style="text-align: center">总统计</h3>
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
    </table>--}}
@endsection