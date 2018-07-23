<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class ShopCategoryController extends Controller
{
    //分类首页
    public function index()
    {
        $categorys=ShopCategory::paginate(3);
        return view('admin.shop_category.index',compact("categorys"));
    }

    //添加分类
    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|min:2',
                'logo' => 'image',
                'into' => 'required',
            ]);
            $data=$request->all();
            //dd($data);
            $data['logo']="";
            if ($request->file('logo')){
                //上传图片
                $data['logo']= $request->file('logo')->store("shop_category","images");
            }

            //入库
            ShopCategory::create($data);
            //提示信息
            $request->session()->flash("success","添加成功");
            //跳转
            return redirect()->route("shop_category.index");

        }
        return view("admin.shop_category.add");
    }

    //编辑分类
    public function edit(Request $request,$id)
    {
        $category=ShopCategory::find($id);
        if ($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|min:2',
                'logo' => 'image',
                'into' => 'required',
            ]);
            $data=$request->all();
            $data['logo']="";
            if ($request->file('logo')){
                //上传图片
                $data['logo']= $request->file('logo')->store("shop_category","images");
            }
            //dd($data);
            //入库
            $category->update($data);
            //提示信息
            $request->session()->flash("success","编辑成功");
            //跳转
            return redirect()->route("shop_category.index");

        }
        return view("admin.shop_category.edit",compact("category"));
    }

    //删除分类
    public function del(Request $request,$id)
    {
        //通过id找到对象
        $category=ShopCategory::find($id);
        File::delete($category->logo);
        //删除
        if ($category->delete()) {
            //跳转
            $request->session()->flash("success","删除成功");
            return redirect()->route("shop_category.index");
        }
    }

}
