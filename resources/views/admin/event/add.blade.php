@extends('layouts.admin.default')
@section('title',"抽奖活动添加")
@section('content')

    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        抽奖活动名称：<input type="text" name="title" value="{{old('title')}}" class="form-control"><br>
        抽奖活动内容：
        <!-- 编辑器容器 -->
        <script id="container" name="content" type="text/plain" ></script>
        <br/>
        报名开始时间：<input type="datetime-local" name="start_time" class="form-control"><br>
        报名结束时间 ：<input type="datetime-local" name="end_time" class="form-control"><br>
        开奖时间 ：<input type="datetime-local" name="prize_time" class="form-control"><br>
        报名人数限制 ：<input type="text" name="num" class="form-control"><br>
        是否已开奖 ：<input type="checkbox" name="is_prize" class="form-control" value="1">未开奖
                    <input type="checkbox" name="is_prize" class="form-control" value="1">已开奖
   <br/>
        <input type="submit" class=" btn btn-info" value="添加">

    </form>
@endsection