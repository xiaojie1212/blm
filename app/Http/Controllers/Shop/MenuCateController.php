<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategories;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuCateController extends Controller
{
    public function index()
    {
        $id=Auth::user()->shop_id;
        $menucates=MenuCategories::where('shop_id',$id)->get();
        return view('shop.menucate.index',compact('menucates'));
    }
    public function add(Request $request)
    {

        if ($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|min:2',
                'description' => 'required',
            ]);
            $shopId=Auth::user()->shop_id;
            if ($request->is_selected== 1){
                MenuCategories::where('is_selected','1')->where('shop_id',$shopId)->update(['is_selected'=>0]);
            }
            $data=$request->all();
            $data['shop_id']=Auth::user()->shop_id;
            //入库
            MenuCategories::create($data);
            //跳转
            return redirect()->route("menucate.index")->with("success","添加成功");

        }

        return view('shop.menucate.add',compact('shops'));
    }

    public function edit(Request $request,$id)
    {
        $menucate=MenuCategories::findOrFail($id);
        if ($request->isMethod('post')){
            $this->validate($request, [
                'name' => 'required|min:2',
                'description' => 'required',
            ]);
            $shopId=Auth::user()->shop_id;
            if ($request->is_selected== 1){
                $menucate->where('is_selected','1')->where('shop_id',$shopId)->update(['is_selected'=>0]);
            }
            $data=$request->all();
            //入库
            $menucate->update($data);
            //跳转
            return redirect()->route("menucate.index")->with("success","编辑成功");

        }

        return view('shop.menucate.edit',compact('shops','menucate'));
    }

    //删除分类
    public function del(Request $request,$id)
    {
            //通过id找到对象
            $menucate=MenuCategories::findOrFail($id);
            $menu=Menu::where('category_id',$id)->count();
            //删除
        if ($menu){
            return redirect()->route("menucate.index")->with("danger","有菜品的分类不能删除");
        }
            $menucate->delete();
            //跳转
            $request->session()->flash("success","删除成功");
            return redirect()->route("menucate.index");
    }
}
