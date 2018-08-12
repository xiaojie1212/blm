<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventPrizeController extends BaseController
{
    public function index(){
        $prizes=EventPrize::paginate(3);
        //返回抽奖内容
        $events=Event::all();
        return view('admin.eventPrize.index',compact('prizes'));
    }

    public function add(Request $request){
        if($request->isMethod('post')){

            $this->validate($request, [
                'name' => 'required',
                'events_id' => 'required',
                'description' => 'required',
            ]);
//  开奖前可以给该活动添加、修改、删除奖品]
// 添加的产品不能大于限制的报名数
            $event= Event::where('id',$request->post('events_id'))->first();
//得到当前报名总数
            $num=$event->num;
// 得到目前的奖品添加了多少了
            $query= EventPrize::where('events_id', $request->post('event_id'))
                ->Select(DB::raw("count(*) AS count "))->first();
if($query->count>=$num){
    return redirect()->route('eventPrize.index')->with('danger',"奖品不能多于报名数，不能添加");
}
      if($event->is_prize !==1){

          return redirect()->route('eventPrize.add')->with('danger',"抽奖活动已结束，不能添加");

      }
            $data=$request->all();
//            还没有开始抽奖 默认0
            $data['user_id']=0;
            EventPrize::create($data);
            return redirect()->route('eventPrize.index')->with('success',"添加成功");
        }
//  返回抽奖内容
        $events=Event::all();
        return view('admin.eventPrize.add',compact('events'));
    }

    public function edit(Request $request,$id){
        $prize=EventPrize::find($id);
       $events= Event::all();
       if($request->isMethod('post')){
           $this->validate($request, [
               'name' => 'required',
               'events_id' => 'required',
               'description' => 'required',
           ]);

//            开奖前可以给该活动添加、修改、删除奖品]
           if( Event::where('id',$request->post('events_id'))->first()->is_prize==1){

               return redirect()->route('eventPrize.index')->with('danger',"抽奖活动已结束，不能修改");

           } ;
           $data=$request->all();
//            还没有开始抽奖 默认
           $data['user_id']=0;
           $prize->update($data);
           return redirect()->route('eventPrize.index')->with('warning',"编辑成功");
       }

        return view('admin.eventPrize.edit',compact('events','prize'));
    }

    public function del(Request $request,$id){
        $prize=EventPrize::find($id);

        if( Event::where('id',$prize->event_id)->first()->is_prize==1){
            return redirect()->route('eventPrize.index')->with('danger',"抽奖活动已结束，不能删除");
           } ;
        $prize=EventPrize::find($id);
        $prize->delete();

        return redirect()->route('eventPrize.index')->with('danger',"删除成功");
    }
//奖品中奖展示
      public function winner(Request $request,$id){
     $prizes=EventPrize::where('user_id',$id)->get();

     return view('admin.eventPrize.winner',compact('prizes'));
     }
}
