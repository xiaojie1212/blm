@extends('layouts.shop.default')
@section("title","菜品分类添加列表")
@section('content')
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        分类名称：<input type="text" name="name" value="{{old('name')}}" class="form-control"><br>
        菜品编号：<input type="text" name="type_accumulation" value="{{old('type_accumulation')}}" class="form-control"><br>
        菜品分类描述：<input type="text" name="description" value="{{old('description')}}" class="form-control"><br>
        是否默认菜品：<input type="radio" value="1" name="is_selected">是
        <input type="radio" value="0" name="is_selected">否<br>
        <input type="submit" value="提交" class="btn btn-success">
    </form>
@endsection