@extends('layouts.admin.default')
@section('title',"添加账号")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    平台用户：<input type="text" name="name" value="{{old('name')}}" class="form-control"><br>
    电子邮箱：<input type="email" name="email"  value="{{old('email')}}" class="form-control"><br>
    用户密码：<input type="password" name="password" class="form-control"><br>
        <input type="submit" value="提交">
</form>
@endsection