@extends('layouts.shop.default')
@section("title","菜品列表")
@section('content')


    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="{{route("menu.add")}}" class="navbar-brand ">添加</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <select name="menu_id" class="form-control">
                            <option value="">请选择分类</option>
                            @foreach($menucates as $menucate)
                            <option value="{{$menucate->id}}" @if(request()->input("menu_id")==$menucate->id) selected @endif >{{$menucate->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="minPrice" class="form-control" size="2" placeholder="最低价"
                           value="{{request()->input('minPrice')}}"> -
                    <input type="text" name="maxPrice" class="form-control" size="2" placeholder="最高价"
                           value="{{request()->input('maxPrice')}}">
                    <div class="form-group">
                        <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="form-control" placeholder="菜品名称">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </nav>


   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>菜品图片</th>
           <th>菜品名称</th>
           <th>所属分类</th>
           <th>价格</th>
           <th>描述</th>
           <th>提示信息</th>
           <th>是否默认分类</th>
           <th>操作</th>
       </tr>
       @foreach($menus as $menu)
       <tr>
           <td>{{$menu->id}}</td>
           <td><img src="/uploads/{{$menu->goods_img}}" width="60"></td>
           <td>{{$menu->goods_name}}</td>
           <td>{{$menu->menucate->name}}</td>
           <td>{{$menu->goods_price}}</td>
           <td>{{$menu->description}}</td>
           <td>{{$menu->tips}}</td>
           <td>{{$menu->status===1?"上架":"下架"}}</td>
           <td>
               <a href="{{route("menu.edit",$menu->id)}}" class="btn btn-warning">编辑</a>
               <a href="{{route("menu.del",$menu->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
        @endforeach
   </table>
    {{$menus->appends($arr)->links()}}
@endsection