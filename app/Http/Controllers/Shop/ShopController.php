<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ShopController extends Controller
{
    public function index()
    {
        $shops=Shop::paginate(3);
        return view('shop.shop.index',compact('shops'));
    }

    public function reg(Request $request)
    {
        $cates=ShopCategory::all();
        if ($request->isMethod('post')){
            $data['name']=$request->post('name');
            $data['password']=$request->post('password');
            $data['email']=$request->post('email');

            if (User::create($data)) {
                $datas['shop_name']=$request->post('shop_name');
                $datas['shop_category_id']=$request->post('shop_category_id');
                $datas['img']="";
                if ($request->file('img')){
                    //上传图片
                    $datas['img']= $request->file('img')->store("shops","images");
                }
                $datas['brand']=$request->post('brand');
                $datas['on_time']=$request->post('on_time');
                $datas['fengniao']=$request->post('fengniao');
                $datas['bao']=$request->post('bao');
                $datas['piao']=$request->post('piao');
                $datas['zhun']=$request->post('zhun');
                $datas['start_send']=$request->post('start_send');
                $datas['send_cost']=$request->post('send_cost');

                Shop::create($datas);
                $request->session()->flash("success","注册成功,等待管理员审核");
                return redirect()->route("shop.index");
            }



        }
        return view("shop.shop.reg",compact("cates"));
    }

    /**
     * 编辑
     * @param Request $request
     * @param $id
     *
     */
    public function edit(Request $request,$id)
    {
//        找到数据
        $cates=ShopCategory::all();
        $shop=Shop::findOrFail($id);
        $user=User::findOrFail($id);
//        判断接收方式
        if ($request->isMethod('post')) {
            //健壮性
            $this->validate($request,[
                "name" => "required|min:2",
                "password" => "required",
                "email" => "required|email",
                "shop_name" => "required|min:2",
                "start_send" => "required",
                "send_cost" => "required",
            ]);
//     接受数据
            $data['name'] = $request->post('name');
            $data['password'] = $request->post('password');
            $data['email'] = $request->post('email');
            if ($user->update($data)) {
                $date['shop_name'] = $request->post('shop_name');
                $date['shop_category_id'] = $request->post('shop_category_id');
                $date['img']="";
                if ($request->file('img')){
                    //上传图片
                    $date['img']= $request->file('img')->store("shops","images");
                }
                $date['brand'] = $request->post('brand');
                $date['on_time'] = $request->post('on_time');
                $date['fengniao'] = $request->post('fengniao');
                $date['bao'] = $request->post('bao');
                $date['piao'] = $request->post('piao');
                $date['zhun'] = $request->post('zhun');
                $date['start_send'] = $request->post('start_send');
                $date['send_cost'] = $request->post('send_cost');
                if ($shop->update($date)) {
                    $request->session()->flash("success", "编辑成功,等待管理员审核");
                    return redirect()->route("shop.index");
                }
            }
        }
//显示视图并传递数据
        return view("shop.shop.edit",compact("cates","shop","user"));
    }


    /**
     * 删除
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id){
        $user=User::findOrFail($id);
        $shop=Shop::findOrFail($id);
        if ($user->delete()) {
            $shop->delete();
            File::delete("/uploads/{$shop->img}");
            $request->session()->flash("success","已取消商家协议");
            return redirect()->route("shop.index");
        }
    }


}
