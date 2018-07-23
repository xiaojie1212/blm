@extends('layouts.shop.default')
@section("title","菜品分类列表")
@section('content')
    <a href="{{route("menucate.add")}}" class="btn btn-info">添加</a>
   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>分类名称</th>
           <th>分类编号</th>
           <th>描述</th>
           <th>是否默认分类</th>
           <th>操作</th>
       </tr>
       @foreach($menucates as $menucate)
       <tr>
           <td>{{$menucate->id}}</td>
           <td>{{$menucate->name}}</td>
           <td>{{$menucate->type_accumulation}}</td>
           <td>{{$menucate->description}}</td>
           <td>{{$menucate->is_selected==1?"是":"否"}}</td>
           <td>
               <a href="{{route("menucate.edit",$menucate->id)}}" class="btn btn-warning">编辑</a>
               <a href="{{route("menucate.del",$menucate->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
        @endforeach
   </table>
@endsection