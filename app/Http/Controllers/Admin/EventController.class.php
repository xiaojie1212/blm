<?php
/**
 * Created by PhpStorm.
 * User: XiaoJie
 * Date: 2018/8/7
 * Time: 18:05
 */

namespace App\Http\Controllers\Admin;
use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index(){
        $events=Event::all();
        return view('admin.event.index',compact('events'));
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $data=$request->post();
            Event::create($data);
            $request->session()->flash("success",'添加成功');
            return redirect()->route('event.index');
        }
        return view('admin.event.add');
    }
    public function edit(Request $request,$id){
        $event=Event::findOrFail($id);
        if($request->isMethod('post')) {
            $data = $request->post();
            $event->update($data);
            $request->session()->flash("success", '编辑成功');
            return redirect()->route('event.index');
        }
        return view('admin.event.edit',compact('event'));
    }
    public function del(Request $request,$id){
        $event=Event::findOrFail($id);
        $date=date('Y-m-d');
        if ($event->prize_time > $date ){

            $request->session()->flash("danger",'抽奖活动为结束，不能删除');
            return redirect()->route('event.index');
        }
        $event->delete();
        $request->session()->flash("success","删除成功");
        return redirect()->route('event.index');
    }
// 开奖
    public function bonus(Request $request,$id){
//    首先得到所有报名此活动的商家和奖品
//    dd($id);
        $event= Event::find($id);
        $event->is_prize=0;
        $event->save();
//    改变抽奖状态:

        $eventusers= EventMember::where('events_id',$id)->pluck('user_id');
//    得到一个由商家构成的数组
//    定义一个空数组
        $prizeArray=[];
        $userArray=$eventusers->toArray();
//打乱抽奖人数组
        shuffle($userArray);
//   得到对应的奖品
        $prizes=EventPrize::where('events_id',$id)->pluck('user_id');
        $prizeArray=$prizes->toArray();

        shuffle($prizeArray);
        for ($x=0; $x<count($prizeArray); $x++) {
            array_shift($userArray);
            $bb=$prizeArray[0];

            array_shift($prizeArray);

            $us= EventPrize::where('user_id',$bb)->first();
            $us->user_id=$userArray[0];
            $us->save();

        }


        return redirect()->route('event.index')->with("success","开奖结束");


    }
//商家报名列表
    public function list(Request  $request,$id){

        $eventMembers= EventMember::where('events_id',$id)->get();
        return view('admin.event.list',compact('eventMembers'));
    }
//此活动奖品
    public function prizeList(Request  $request,$id){
        $prizes=EventPrize::where('events_id',$id)->get();
//        返回抽奖内容
        $events=Event::all();
        return view('admin.event.prize',compact('prizes'));
    }

}
