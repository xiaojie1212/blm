<?php

namespace App\Http\Controllers\shop;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends BaseController
{
    public function index()
    {
        $events = Event::where('is_prize', 1)->get();
        return view('shop.event.index', compact("events"));
    }

    public function signUp(Request $request, $id)
    {
        $data['user_id'] = Auth::user()->id;
        $data['events_id'] = $id;

        $query= EventMember::where('events_id',$data['events_id'] )->count();

        $num=Event::find($id)->num;
        if($query>=$num){
            return redirect()->route('events.index')->with('danger',"对不起报名人数已满");
        };
        if(EventMember::where('user_id', $data['user_id'])->where('events_id', $data['events_id'])->first()){

            return redirect()->route('events.index')->with('danger',"对不起,你已经报过名了");

        };
        EventMember::create($data);
        $request->session()->flash("success", "报名成功");
        return redirect()->route('events.index');
    }
    public function winner(Request $request){
        $id=Auth::user()->id;

        $prizes=EventPrize::where('events_id',$id)->get();
        return view('shop.event.winner',compact('prizes'));
    }
}
