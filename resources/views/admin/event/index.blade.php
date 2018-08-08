@extends('layouts.admin.default')
@section("title","抽奖活动首页")
@section('content')
    <a href="{{route('event.add')}}"class="btn btn-info">添加</a>
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>活动名称</th>
            <th>活动详情</th>
            <th>报名开始时间</th>
            <th>报名结束时间</th>
            <th>开奖时间</th>
            <th>是否已开奖</th>

            <th>操作</th>
        </tr>

        <tr>
            @foreach($events as $event)
                <td>{{$event->id}}</td>
                <td>{{$event->title}}</td>
                <td>{!!$event->content!!}</td>
                <td>{{$event->start_time}}</td>
                <td>{{$event->end_time}}</td>
                <td>{{$event->prize_time}}</td>
                <td>
                    @if($event->is_prize===1)
                        <a href="#" class="btn btn-success">未开奖</a>
                    @elseif($event->is_prize===0)
                        <a href="#" class="btn btn-danger">已开奖</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('event.edit',$event->id)}}"class="btn btn-info">编辑</a>
                    <a href="{{route('event.del',$event->id)}}"class="btn btn-danger">删除</a>
                    {{--<a class="btn btn-danger glyphicon glyphicon-trash" href="{{route('event.del',['id'=>$event->id])}}"></a>--}}
                    {{--@if($event->is_prize==0)    <a class="btn btn-danger" href="javascript:;">已开奖</a> @endif--}}
                    @if($event->is_prize==1 )     <a class="btn btn-success" href="{{route('event.bonus',['id'=>$event->id])}}">开奖</a>@endif
                    <a class="btn btn-info" href="{{route('event.list',$event->id)}}">报名列表</a>
                    <a class="btn btn-warning" href="{{route('event.prizeList',$event->id)}}">奖品列表</a>
                    <a class="btn btn-success" href="{{route('eventPrize.winner',$event->id)}}">获奖列表</a>
                </td>

        </tr>
        @endforeach
    </table>
    {{--{{$members->appends("query")->links()}}--}}

@endsection