@extends('layouts.admin.default')
@section('title',"抽奖活动编辑")
@section('content')

    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        抽奖活动名称：<input type="text" name="title" value="{{old('title',$event->title)}}" class="form-control"><br>
        抽奖活动内容：
        <!-- 编辑器容器 -->
        <script id="container" name="content" type="text/plain" >{!!$event->content!!}</script>
        <br/>

        报名开始时间：<input   type="date" name="start_time" class="form-control" value="{{old('start_time',$event->start_time)}}"><br>
        报名结束时间 ：<input type="date" name="end_time" class="form-control" value="{{old('end_time',$event->end_time)}}"><br>
        开奖时间 ：<input type="date" name="prize_time" class="form-control" value="{{old('prize_time',$event->prize_time)}}"><br>
        报名人数限制 ：<input type="text" name="num" class="form-control" value="{{old('num',$event->num)}}"><br>
        是否已开奖 ：<input type="checkbox" name="is_prize" class="form-control" value="1"{{$event->is_prize?"checked":""}}>未开奖
                    <input type="checkbox" name="is_prize" class="form-control" value="0"{{$event->is_prize?"":"checked"}}>已开奖
   <br/>
        <input type="submit" class=" btn btn-info" value="编辑">

    </form>
@endsection