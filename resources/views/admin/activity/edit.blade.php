@extends('layouts.admin.default')
@section('title',"添加管理员账号")
@section('content')

    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        活动名称：<input type="text" name="title" value="{{old('title',$act->title)}}" class="form-control"><br>
        活动内容：
        <!-- 编辑器容器 -->
        <script id="container" name="content" type="text/plain">{!!old('content',$act->content)!!}</script>
        <br/>
        活动开始时间：<input type="date" name="start_time" class="form-control" value="{{$act->start_time}}"><br>
        活动结束时间 ：<input type="date" name="end_time" class="form-control" value="{{$act->end_time}}"><br>
        <input type="submit" class="btn btn-success" value="编辑">
    </form>
@endsection
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>


@endsection