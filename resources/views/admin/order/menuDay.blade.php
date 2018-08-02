@extends('layouts.admin.default')
@section("title","菜品每日销量")
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
                    <div class="form-group">
                        <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="form-control" placeholder="菜品名称">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
            </div>
        </div>
    </nav>
    @if($shopId == "")
        <h3 style="text-align: center">所有商家菜品每日订单总量统计</h3>
    @elseif($shopId == $id)
        <h3 style="text-align: center">所搜索的商家菜品每日订单统计</h3>
    @endif
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
@endsection