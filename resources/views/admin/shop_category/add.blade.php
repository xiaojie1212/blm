@extends('layouts.admin.default')
@section("title","商家分类添加列表")
@section('content')
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        分类名称：<input type="text" name="name" value="{{old('name')}}" class="form-control"><br>
        分类图片：<input type="file" name="logo" class="form-control"><br>
        商品简介：<input type="text" name="into" value="{{old('into')}}" class="form-control"><br>
        是否显示：<input type="checkbox" value="1" name="status">是
                <input type="checkbox" value="0" name="status">否<br>
        <input type="submit" value="提交" class="btn btn-success">
    </form>
@endsection