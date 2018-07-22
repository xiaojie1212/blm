@extends('layouts.admin.default')
@section('title',"编辑账号")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    旧密码：<input type="password" name="password" class="form-control"><br>
    <span></span><br>
    <span></span><br>
    新密码：<input type="password" name="newPassword" class="form-control"><br>
    <span></span><br>
    <span></span><br>
        <input type="submit" value="提交" class="btn btn-warning">
</form>
@endsection