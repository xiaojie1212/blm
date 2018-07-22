@extends('layouts.admin.default')
@section("title","平台账号列表")
@section('content')
    <a href="{{route("admin.add")}}" class="btn btn-info">添加</a>
   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>账号</th>
           <th>电子邮箱</th>
           <th>操作</th>
       </tr>
       @foreach($admins as $admin)
       <tr>
           <td>{{$admin->id}}</td>
           <td>{{$admin->name}}</td>
           <td>{{$admin->email}}</td>
           <td>
               <a href="{{route("admin.edit",$admin->id)}}" class="btn btn-warning">修改密码</a>
               <a href="{{route("admin.del",$admin->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
        @endforeach
   </table>
@endsection