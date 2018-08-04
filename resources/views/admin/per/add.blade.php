@extends('layouts.admin.default')
@section('title',"添加权限")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data" style="text-align: center">
    {{ csrf_field() }}
    权限名称：<input type="text" name="name" value="{{old('name')}}" class="form-control" ><br>
        <input type="submit" class="btn btn-warning" style="margin-top: 50px;" value="提交">
</form>
@endsection