    @extends('layouts.admin.default')
    @section("title","获奖首页")
    @section('content')

<h1 style="color: red" class="text-center">中奖名单</h1>
   <table class="table table-hover"  >
     <tr >
         <th >id</th>
         <th>获奖奖品</th>
         <th>获奖商家</th>
     </tr>
      @foreach($prizes as $prize)
          @if($prize->user_id !=0)
               <tr  >
                   <td>{{$prize->id}}</td>
                   <td >{{$prize->name}}</td>
                   <td>
                       {{$prize->user->name}}
                   </td>
               </tr>
           @endif

          @endforeach
   </table>
        {{--{{$prizes->links()}}--}}

    @endsection
