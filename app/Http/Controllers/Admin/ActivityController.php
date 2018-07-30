<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index(Request $request)
    {

        $times=\request()->input('status');
        $date=date(now());
        $query=Activity::orderBy('id');
        $a=$request->query();
        if ($times==-1){
            $query->where('start_time','>=',$date);
        }
        if ($times==1){
            $query->where('start_time','<=',$date)
                ->Where('end_time','>=',$date);
        }
        if ($times==2){
            $query->where('end_time','<=',$date);
        }
        $acts=$query->paginate(3);
        return view('admin.activity.index',compact('acts','a'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|min:2',
                'content' => 'required',
            ]);
            $data = $request->post();
            Activity::create($data);
                session()->flash("success", "添加成功");
                return redirect()->route("activity.index");

        }
        return view('admin.activity.add');
    }
    public function edit(Request $request,$id)
    {
        $act=Activity::findOrFail($id);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|min:2',
                'content' => 'required',
            ]);
            $data = $request->post();

            $act->update($data);
            session()->flash("success", "编辑成功");
            return redirect()->route("activity.index");

        }
        return view("admin.activity.edit",compact('act'));
    }
    public function del($id)
    {
        $act=Activity::findOrFail($id);
        $act->delete();
        session()->flash("success", "删除成功");
        return redirect()->route("activity.index");
    }
}
