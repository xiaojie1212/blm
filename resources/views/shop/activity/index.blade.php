@extends('layouts.shop.default')
@section("title","活动列表")
@section('content')
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>活动标题</th>
            <th>活动内容</th>
            <th>开始时间</th>
            <th>结束时间</th>
        </tr>
        @foreach($acts as $act)
            <tr>
                <td>{{$act->id}}</td>
                <td>{{$act->title}}</td>
                <td>{!!$act->content!!}</td>
                <td>{{$act->start_time}}</td>
                <td>{{$act->end_time}}</td>
            </tr>
        @endforeach
    </table>
{{$acts->links()}}
@endsection