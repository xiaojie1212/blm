@extends('layouts.admin.default')
@section("title","商家账号列表")
@section('content')
    <a href="{{route("shop.reg")}}" class="btn btn-success">添加商户</a>
   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>账号</th>
           <th>电子邮箱</th>
           <th>所属商家</th>
           <th>状态</th>
           <th>操作</th>
       </tr>
       @foreach($userIndexs as $userIndex)
       <tr>
           <td>{{$userIndex->id}}</td>
           <td>{{$userIndex->name}}</td>
           <td>{{$userIndex->email}}</td>
           <td>{{$userIndex->shop->shop_name}}</td>
           <td>{{\App\Models\User::$userStatus[$userIndex->status]}}</td>
           <td>
               <a href="{{route("admin.reset",$userIndex->id)}}" class="btn btn-warning">重置密码</a>
               @if($userIndex->status===0)
                   <a href="{{route('admin.audit',$userIndex->id)}}" class="btn btn-info">审核</a>
               @endif
           </td>




       </tr>
        @endforeach
   </table>
{{$userIndexs->links()}}
@endsection