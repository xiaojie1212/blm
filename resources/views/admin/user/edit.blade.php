@extends('layouts.admin.default')
@section('title',"编辑账号")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    用户名称：<input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control"><br>
    电子邮箱：<input type="email" name="email"  value="{{old('email',$user->email)}}" class="form-control"><br>
    用户密码：<input type="password" name="password" class="form-control"><br>
    所属商家ID：<input type="text" name="shop_id" class="form-control" value="{{old('shop_id',$user->shop_id)}}"><br>
    是否启用：<label>
        <input type="checkbox" value="1" name="status" {{$user->status?"checked":""}}>是
    </label>
    <label>
        <input type="checkbox" value="0" name="status" {{$user->status?"checked":""}}>否
    </label><br>
        <input type="submit" value="提交">
</form>
@endsection