@extends('layouts.admin.default')
@section("title","平台账号列表")
@section('content')
    <div class="box-header">

        <div class="box-tools">
            <a class="btn btn-info" href="{{route("activity.add")}}">添加</a>
            <form class="navbar-form navbar-right"action="" method="get">
                <select name="status" class="form-control">
                    <option value="">请选择</option>
                    <option value="-1" @if(request()->input("status")==-1) selected @endif>未开始</option>
                    <option value="1" @if(request()->input("status")==1) selected @endif>已开始</option>
                    <option value="2" @if(request()->input("status")==2) selected @endif>已结束</option>
                </select>

                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </div>


   <table class="table table-bordered">
       <tr>
           <th>id</th>
           <th>活动标题</th>
           <th>活动内容</th>
           <th>开始时间</th>
           <th>结束时间</th>
           <th>操作</th>
       </tr>
       @foreach($acts as $act)
       <tr>
           <td>{{$act->id}}</td>
           <td>{{$act->title}}</td>
           <td>{!!$act->content!!}</td>
           <td>{{$act->start_time}}</td>
           <td>{{$act->end_time}}</td>
           <td>
               <a href="{{route("activity.edit",$act->id)}}" class="btn btn-warning">编辑</a>
               <a href="{{route("activity.del",$act->id)}}" class="btn btn-danger">删除</a>
           </td>
       </tr>
        @endforeach
   </table>
    {{$acts->appends($a)->links()}}
@endsection