@extends('layouts.admin.default')
@section("title","权限列表")
@section('content')
    <a href="{{route('per.add')}}" class="btn btn-warning">添加</a>
   <table class="table table-bordered">
       <tr>
           <th>ID</th>
           <th>name</th>
           <th>保安</th>
           <th>操作</th>
       </tr>
       @foreach($pers as $per)
       <tr>
           <td>{{$per->id}}</td>
           <td>{{$per->name}}</td>
           <td>{{$per->guard_name}}</td>
           <td>
               <a href="{{route('per.del',$per->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
       @endforeach
   </table>
@endsection