@extends('layouts.admin.default')
@section('title',"编辑权限")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div  class="row col-md-12">
        角色名称：<input type="text" name="name" value="{{$role->name}}" class="form-control" ><br>
        权限名称:
    </div>
    @foreach($pers as $per)
        <div class="row col-md-4">
            <input type="checkbox" name="per[]"
                   @if($role->hasPermissionTo($per->name)) checked @endif
                   value="{{$per->name}}">{{$per->name}}
        </div>
    @endforeach
        <div class="row col-md-12">
            <input type="submit" class="btn btn-warning" value="提交">
        </div>
</form>
@endsection