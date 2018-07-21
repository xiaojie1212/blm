@extends('layouts.admin.default')
@section("title","商家分类列表")
@section('content')
    <a href="{{route("shop_category.add")}}" class="btn btn-info">添加</a>
   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>分类名称</th>
           <th>分类图片</th>
           <th>简介</th>
           <th>是否显示</th>
           <th>操作</th>
       </tr>
       @foreach($categorys as $category)
       <tr>
           <td>{{$category->id}}</td>
           <td>{{$category->name}}</td>
           <td><img src="/uploads/{{$category->logo}}" width="50"></td>
           <td>{{$category->into}}</td>
           <td>{{$category->status===1?"显示":"隐藏"}}</td>
           <td>
               <a href="{{route("shop_category.edit",$category->id)}}" class="btn btn-warning">编辑</a>
               <a href="{{route("shop_category.del",$category->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
        @endforeach
   </table>
{{$categorys->links()}}
@endsection