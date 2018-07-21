<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users=User::paginate(3);
        return view('admin.user.index',compact("users"));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //健壮性
            $this->validate($request, [
                'name' => 'required|min:2',
                'email' => 'required|email',
                'password' => 'required|min:2',
            ]);
            $data=$request->all();
            User::create($data);
                $request->session()->flash("success","添加成功");
                return redirect()->route("user.index");
            }

        return view("admin.user.add");
    }

    public function edit(Request $request,$id)
    {
        $user=User::find($id);
        if ($request->isMethod('post')){
            //健壮性
            $this->validate($request, [
                'name' => 'required|min:2',
                'email' => 'required|email',
                'password' => 'required|min:2',
            ]);
            $data=$request->all();
            $user->update($data);
            $request->session()->flash("success","修改成功");
            return redirect()->route("user.index");
        }
        return view("admin.user.edit",compact('user'));
    }

    public function del(Request $request,$id)
    {
        //通过id找到对象
        $user=User::find($id);
        //删除
        if ($user->delete()) {
            //跳转
            $request->session()->flash("success","删除成功");
            return redirect()->route("user.index");
        }
    }
}
