<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PerController extends BaseController
{
    //首页
    public function index()
    {
        $pers=Permission::all();
        return view('admin.per.index',compact('pers'));
    }

    //添加权限
    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required',
            ]);
            //接收参数
            $data['name']=$request->post('name');
            $data['guard_name']="admin";
            $per=Permission::create($data);
            //跳转并提示
            return redirect()->route('per.index')->with('success','创建成功');
        }

        return view('admin.per.add');
    }

    //删除权限
    public function del($id)
    {
        $per=Permission::findOrFail($id);
        $per->delete();
        //跳转并提示
        return redirect()->route('per.index')->with('success','删除成功');
    }
}
