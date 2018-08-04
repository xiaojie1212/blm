@extends('layouts.admin.default')
@section("title","角色列表")
@section('content')
    <a href="{{route('role.add')}}" class="btn btn-warning">添加</a>
   <table class="table table-bordered">
       <tr>
           <th>ID</th>
           <th>name</th>
           <th>保安</th>
           <th>操作</th>
       </tr>
       @foreach($roles as $role)
       <tr>
           <td>{{$role->id}}</td>
           <td>{{$role->name}}</td>
           <td>{{$role->guard_name}}</td>
           <td>
               <a href="{{route('role.edit',$role->id)}}" class="btn btn-info">编辑</a>
               <a href="{{route('role.del',$role->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
       @endforeach
   </table>
@endsection