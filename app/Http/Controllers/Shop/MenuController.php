<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategories;
use App\Models\Shop;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        //接收参数
        $minPrice=\request()->input('minPrice');
        $maxPrice=\request()->input('maxPrice');
        $keywords=\request()->input('keywords');
        $menuId=\request()->input('menu_id');
        $id=Auth::user()->id;
        $query=Menu::orderBy('id')->where('shop_id',$id);
        if ($minPrice!==null){
            $query->where('goods_price','>=',$minPrice);
        }

        if ($maxPrice!==null){
            $query->where('goods_price','<=',$maxPrice);
        }

        if ($keywords!==null){
            $query->where('goods_name','like',"%{$keywords}%");
        }
        if ($menuId!==null){
            $query->where('category_id','=',$menuId);
        }
        $menus = $query->paginate(2);
        $menucates=MenuCategories::all();
        $arr=$request->query();
        return view('shop.menu.index',compact('menus','menucates','arr'));
    }

    public function add(Request $request)
    {
        $menucates=MenuCategories::all();
        if ($request->isMethod('post')){
            $this->validate($request, [
                'goods_name' => 'required|min:2',
                'description' => 'required',
            ]);
            $data=$request->all();
            $data['goods_img']="";
            if ($request->file('goods_img')){
                //上传图片
                $data['goods_img']= $request->file('goods_img')->store("menu","images");
            }
            $data['shop_id']=Auth::user()->shop_id;
            //入库
            Menu::create($data);
            //跳转
            return redirect()->route("menu.index")->with("success","添加成功");

        }
        return view('shop.menu.add',compact('menucates'));
    }

    public function edit(Request $request,$id)
    {
        $menu=Menu::findOrFail($id);
        $menucates=MenuCategories::all();
        if ($request->isMethod('post')){
            $this->validate($request, [
                'goods_name' => 'required|min:2',
                'description' => 'required',
            ]);
            $data=$request->all();
            $data['goods_img']="";
            if ($request->file('goods_img')){
                //上传图片
                File::delete(public_path("/uploads/".$menu->goods_img));
                $data['goods_img']= $request->file('goods_img')->store("menu","images");
            }
            //入库
           $menu->update($data);
            //跳转
            return redirect()->route("menu.index")->with("success"," 编辑成功");

        }
        return view('shop.menu.edit',compact('menucates','menu'));
    }
    public function del(Request $request,$id)
    {
        //通过id找到对象
        $menu=Menu::findOrFail($id);
        File::delete(public_path("/uploads/".$menu->goods_img));
        $menu->delete();

        //跳转
        $request->session()->flash("success","删除成功");
        return redirect()->route("menu.index");
    }
}