    @extends('layouts.admin.default')
    @section("title","奖品首页")
    @section('content')

<h1 style="color: red" class="text-center">奖品列表</h1>
<a href="{{route('eventPrize.add')}}" class=" btn btn-warning  glyphicon glyphicon-plus"></a>
   <table class="table table-hover"  >
     <tr >
         <th >id</th>
         <th>活动id</th>
         <th>奖品名称</th>
         <th>奖品详情</th>
         <th>中奖商家</th>
         <th>操作</th>
     </tr>
      @foreach($prizes as $prize)
           <tr  >
               <td >{{$prize->id}}</td>
               <td>{{$prize->event->title}}</td>
               <td> {{$prize->name}}</td>
               <td>{{$prize->description}}</td>
               <td>
                   {{$prize->user_id}}
               </td>
           <td>

            <a class="btn btn-info glyphicon glyphicon-edit" href="{{route('eventPrize.edit',['id'=>$prize->id])}}"></a>
               <a class="btn btn-danger glyphicon glyphicon-trash" href="{{route('eventPrize.del',['id'=>$prize->id])}}"></a>

           </td>
       </tr>
          @endforeach
   </table>
        {{$prizes->links()}}

    @endsection
