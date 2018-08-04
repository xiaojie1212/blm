<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    //角色首页
    public function index()
    {
        $roles=Role::all();
        return view('admin.role.index',compact('roles'));
    }

    //添加角色
    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required',
            ]);
            //接收参数
            $data['name']=$request->post('name');
            $data['guard_name']="admin";
            //创建角色
            $role=Role::create($data);
            //给角色添加权限
            $role->syncPermissions($request->post('per'));
            //跳转并提示
            return redirect()->route('role.index')->with('success','创建'.$role->name."成功");
        }
        $pers=Permission::all();
        return view('admin.role.add',compact('pers'));
    }

    //编辑角色
    public function edit(Request $request,$id)
    {
        $role=Role::findOrFail($id);
        if ($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required',
            ]);
            //接收参数
            $data['name']=$request->post('name');
            $data['guard_name']="admin";
            //创建角色
            $role->update($data);
            //给角色添加权限
            $role->syncPermissions($request->post('per'));
            //跳转并提示
            return redirect()->route('role.index')->with('success','编辑'.$role->name."成功");
        }

        $pers=Permission::all();
        return view('admin.role.edit',compact('pers','role'));
    }

    //删除角色
    public function del($id)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        //跳转并提示
        return redirect()->route('role.index')->with('success','删除成功');
    }
}
