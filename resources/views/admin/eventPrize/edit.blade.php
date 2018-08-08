@extends('layouts.admin.default')
@section("title","奖品编辑")
@section("content")、
<h1 style="color: red" class="text-center">奖品编辑</h1>
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label class="col-sm-2 control-label">活动id</label>
            <div class="col-sm-10">

              <select  name="event_id" class="form-control"style="width: 670px">
                  @foreach($events as $event)
                  <option value="{{$event->id}}" @if($event->id==$prize->event_id) selected @endif> {{$event->title}}</option>
                  @endforeach
              </select>

            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">奖品名称</label>
            <div class="col-sm-10" style="width: 700px">
                <input type="text" name="name"  value="{{$prize->name}}" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">奖品详情</label>
            <div class="col-sm-10" style="width: 700px">
                <input type="text" name="description" value="{{$prize->description}}"class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10" style="width: 700px">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>
@endsection