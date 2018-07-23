@extends('layouts.shop.default')
@section("title","菜品编辑列表")
@section('content')
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        名称：<input type="text" name="goods_name" value="{{old('goods_name',$menu->goods_name)}}" class="form-control"><br>

        图片：<img src="/uploads/{{$menu->goods_img}}" width="60">
        <input type="file" name="goods_img" class="form-control"><br>
        所属菜品分类：<select name="category_id">
            @foreach($menucates as $menucate)
                <option value="{{$menucate->id}}" @if($menu->category_id===$menucate->id) selected @endif>{{$menucate->name}}</option>
            @endforeach
        </select><br>
        菜品价格：<input type="text" name="goods_price" value="{{old('goods_price',$menu->goods_price)}}" class="form-control"><br>
        菜品描述：<input type="text" name="description" value="{{old('description',$menu->description)}}" class="form-control"><br>
        提示信息：<input type="text" name="tips" value="{{old('tips',$menu->tips)}}" class="form-control"><br>
        是否上架菜品：<input type="radio" value="1" {{$menu->status?"checked":""}} name="status">是
                    <input type="radio" value="0" {{$menu->status?"":"checked"}} name="status">否<br>
        <input type="submit" value="提交" class="btn btn-success">
    </form>
@endsection