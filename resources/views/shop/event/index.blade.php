@extends('layouts.shop.default')
@section("title","店铺详情列表")
@section('content')
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
                    <a href="{{route('events.signUp',$event->id)}}"class="btn btn-info">报名</a>
                </td>

        </tr>
        @endforeach
    </table>
    {{--{{$members->appends("query")->links()}}--}}

@endsection