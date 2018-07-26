@extends('layouts.admin.default')
@section('title',"添加账号")
@section('content')
<form action="" method="post" class="form-inline" enctype="multipart/form-data">
    {{ csrf_field() }}
    活动标题：<input type="text" name="title" value="{{old('title')}}" class="form-control"><br>
    活动内容：<!-- 编辑器容器 -->
    <script id="container" name="content" type="text/plain"></script>
    开始时间：<input type="date" name="start_time" class="form-control"><br>
    结束时间：<input type="date" name="end_time" class="form-control"><br>
        <input type="submit" value="提交">
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