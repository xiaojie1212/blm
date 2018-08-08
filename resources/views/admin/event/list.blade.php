    @extends('layouts.admin.default')
    @section("title","报名首页")
    @section('content')

<h1 style="color: red" class="text-center">报名列表</h1>
<a href="{{route('event.index')}}" class=" btn btn-warning ">返回</a>
   <table class="table table-hover"  >
     <tr >
         <th >id</th>
         <th>活动</th>
         <th>商家</th>
         {{--<th>操作</th>--}}
     </tr>
      @foreach($eventMembers as $eventMember)
           <tr  >
               <td >{{$eventMember->id}}</td>
               <td>{{$eventMember->event->title}}</td>
               <td> {{$eventMember->user->name}}</td>
           {{--<td>--}}

            {{--<a class="btn btn-info glyphicon glyphicon-edit" href="{{route('eventPrize.edit',['id'=>$prize->id])}}"></a>--}}
               {{--<a class="btn btn-danger glyphicon glyphicon-trash" href="{{route('eventUser.del',['id'=>$eventuser->id])}}"></a>--}}

           {{--</td>--}}
       </tr>
          @endforeach
   </table>
        {{--{{$eventusers->links()}}--}}

    @endsection
