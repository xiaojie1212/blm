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
        $shopId=Auth::user()->id;
        $query=Menu::orderBy('id')->where('shop_id',$shopId);
        if ($minPrice!==null){
            $query->where(' goods_price','>=',$minPrice);
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
        $menucates=MenuCategories::where('shop_id',$shopId)->get();
        $arr=$request->query();
        return view('shop.menu.index',compact('menus','menucates','arr'));
    }

    public function add(Request $request)
    {
        $shopId=Auth::user()->id;
        $menucates=MenuCategories::where('shop_id',$shopId)->get();
        if ($request->isMethod('post')){
            $this->validate($request, [
                'goods_name' => 'required|min:2',
                'description' => 'required',
                'menu_id' =>'required',
            ]);
            $data=$request->all();
            $data['shop_id']=Auth::user()->id;
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
        $shopId=Auth::user()->id;
        $menucates=MenuCategories::where('shop_id',$shopId)->get();
        if ($request->isMethod('post')){
            $this->validate($request, [
                'goods_name' => 'required|min:2',
                'description' => 'required',
                'menu_id' =>'required',
            ]);
            $data=$request->all();
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
    public function upload(Request $request){
        $fileName= $request->file('file')->store('menus','oss');
        $date=[
            'status'=>1,
            'url'=>env("ALIYUN_OSS_URL").$fileName
        ];
        return $date;
    }
}
