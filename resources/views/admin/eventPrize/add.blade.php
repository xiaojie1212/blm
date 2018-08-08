@extends('layouts.admin.default')
@section("title","奖品添加")
@section("content")、
<h1 style="color: red" class="text-center">奖品添加</h1>
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-2 control-label">活动id</label>
            <div class="col-sm-10">

              <select  name="events_id" class="form-control"style="width: 670px">
                  @foreach($events as $event)
                  <option value="{{$event->id}}"> {{$event->title}}</option>
                  @endforeach
              </select>

            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">奖品名称</label>
            <div class="col-sm-10" style="width: 700px">
                <input type="text" name="name" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">奖品详情</label>
            <div class="col-sm-10" style="width: 700px">
                <input type="text" name="description" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10" style="width: 700px">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>
@endsection