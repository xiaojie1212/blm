@extends('layouts.admin.default')
@section('title',"编辑账号")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    角色名称：
    @foreach($roles as $role)
    <input type="checkbox" name="role[]" class="form-control checkbox-inline"
           value="{{$role->name}}"
           @if($admin->hasRole($role->name)) checked @endif
    >{{$role->name}}
    @endforeach
    <br>
    <span></span><br>
    <span></span><br>
        <input type="submit" value="提交" class="btn btn-warning">
</form>
@endsection