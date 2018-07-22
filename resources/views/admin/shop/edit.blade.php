@extends('layouts.admin.default')
@section("title","店铺信息编辑")
@section('content')

    <form action="" method="post" class="form-inline col-sm-8 control-label" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" class="form-control" placeholder="name" name="name" value="{{old("name",$user->name)}}" >
        </div>
        <br/>
        <div class="form-group">
            <input type="password" class="form-control"  placeholder="Password" name="password" value="{{old("email",$user->password)}}" >
        </div>
        <br/>
        <div class="form-group">
            <input type="email" class="form-control"  placeholder="email" name="email" value="{{old("email",$user->email)}}">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="店铺名称" name="shop_name" value="{{old("shop_name",$shop->shop_name)}}">
        </div>
        <br/>
        <div class="form-group">
            店铺分类:<select name="shop_category_id" >
                @foreach($cates as $cate)
                    <option value="{{$cate->id}}"@if($shop->shop_category_id===$cate->id) selected @endif>{{$cate->name}}</option>
                @endforeach
            </select>
        </div>
        <br/>
        <div class="form-group">
            店铺图片:
            <img src="/uploads/{{$shop->img}}" height="100" width="100">
            <input type="file" name="img">
        </div>
        <br/>
        <div class="checkbox">
            是否品牌:<label>
                <input type="checkbox" value="1"{{$shop->brand?"checked":""}} name="brand">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->brand?"":"checked"}} name="brand">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否准时送达:<label>
                <input type="checkbox" value="1"{{$shop->on_time?"checked":""}} name="on_time">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->on_time?"":"checked"}} name="on_time">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否蜂鸟配送:<label>
                <input type="checkbox" value="1" {{$shop->fengniao?"checked":""}} name="fengniao">是
            </label>
            <label>
                <input type="checkbox" value="0" {{$shop->fengniao?"":"checked"}} name="fengniao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否保:<label>
                <input type="checkbox" value="1" {{$shop->bao?"checked":""}} name="bao" >是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->bao?"":"checked"}} name="bao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否票:<label>
                <input type="checkbox" value="1" {{$shop->piao?"checked":""}} name="piao">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->piao?"":"checked"}} name="piao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否准:<label>
                <input type="checkbox" value="1"{{$shop->zhun?"checked":""}} name="zhun">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->zhun?"":"checked"}} name="zhun">否
            </label>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="起送金额" name="start_send" value="{{old("start_send",$shop->start_send)}}">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="配送费" name="send_cost" value="{{old("send_cost",$shop->send_cost)}}">
        </div>
        <br/>
        <button type="submit" class="btn btn-default">提交</button>
    </form>
@endsection