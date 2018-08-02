<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public function index()
    {
        $admins=Admin::all();
        return view('admin.admin.index',compact('admins'));
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
            $data['password']=bcrypt($data['password']);
            Admin::create($data);
            $request->session()->flash("success","添加成功");
            return redirect()->route("admin.index");
        }

        return view('admin.admin.add');
    }

    public function edit(Request $request,$id)
    {
        $admin=Admin::find($id);
        if ($request->isMethod('post')){
            //健壮性
            $this->validate($request, [
                'password' => 'required|min:2',
            ]);
            //验证密码是否一致
            if (Hash::check($request->password,$admin->password)) {
                $request->user()->fill([
                    'password' => Hash::make($request->newPassword)
                ])->save();
                $request->session()->flash("success","修改成功");
                return redirect()->route("admin.index");
            }else{
                $request->session()->flash("danger","旧密码不正确");
                return redirect()->back()->withInput();
            }

        }
        return view("admin.admin.edit",compact('admin'));
    }

    public function del(Request $request,$id)
    {

        if($id==="2" || $id==="1"){
            $request->session()->flash("danger","不能删除超级管理员");
            return redirect()->route("admin.index");
        }
        //通过id找到对象
        $admin=Admin::findOrFail($id);
        //删除
        $admin->delete();
            //跳转
        $request->session()->flash("success","删除成功");
        return redirect()->route("admin.index");

    }

    //登录
    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            //健壮性
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required',
            ]);

            if (Auth::guard('admin')->attempt(['name'=>$request->post('name'),'password'=>$request->post('password')],$request->has('remember'))) {

                //提示
                $request->session()->flash("success","登录成功");
                //跳转
                return redirect()->route('shop.index');

            }else{
                //提示
                $request->session()->flash("danger","账号或密码错误");
                //跳转
                return redirect()->back()->withInput();
            }
        }
        return view("admin.admin.login");
    }
    public function logout()
    {
        Auth::logout();
        //提示
        session()->flash("danger","注销成功");
        return redirect()->route("admin.login");
    }

    public function userIndex()
    {
        $userIndexs=User::paginate(3);
        return view('admin.admin.userIndex',compact('userIndexs'));
    }

    public function audit($id)
    {
        $user=User::findOrFail($id);
        $user->status=1;
        $user->save();
        return back()->with("success","通过审核");
    }

    public function reset($id)
    {
        $user=User::findOrFail($id);
        $user->password=bcrypt(123456);
        $user->save();
        return back()->with("success","密码重置成功");
    }
}
