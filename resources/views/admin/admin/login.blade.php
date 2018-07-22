@extends('layouts.admin.default')
@section('title',"平台登录")
@section('content')
    <h1 style="text-align: center">平台登录</h1>
    <span></span><br>
    <span></span><br>
    <form action="" method="post" class="form-inline" enctype="multipart/form-data" style="text-align: center">
        {{ csrf_field() }}
        用户名称：<input type="text" name="name" value="{{old('name')}}" class="form-control"><br>
        <span></span><br>
        <span></span><br>
        用户密码：<input type="password" name="password" class="form-control"><br>
        <span></span><br>
        <span></span><br>
        <input type="checkbox"  name="remember">             是否记住密码<br>
        <span></span><br>
        <span></span><br>
        <input type="submit" value="提交" class="btn btn-success">
    </form>
@endsection