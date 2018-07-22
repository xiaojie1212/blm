<?php

namespace App\Http\Controllers\Shop;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends \App\Http\Controllers\Shop\BaseController
{
    public function index()
    {
        $shop=Auth::user()->shop;
        return view('shop.user.index',compact("shop"));
    }

    public function edit(Request $request,$id)
    {
        $cates=ShopCategory::where('status','1')->get();
        $shop=Shop::findOrFail($id);
        if ($request->isMethod('post')){

            $datas['shop_name']=$request->post('shop_name');
            $datas['shop_category_id']=$request->post('shop_category_id');
            $datas['img']="";
            if ($request->file('img')){
                //上传图片
                $datas['img']= $request->file('img')->store("shops","images");
            }
            if(!$request->post('brand')){
                $datas['brand']=0;
            }else{
                $datas['brand']=$request->post('brand');
            }
            if(!$request->post('on_time')){
                $datas['on_time']=0;
            }else{
                $datas['on_time']=$request->post('on_time');
            }
            if(!$request->post('fengniao')){
                $datas['fengniao']=0;
            }else{
                $datas['fengniao']=$request->post('fengniao');
            }
            if(!$request->post('bao')){
                $datas['bao']=0;
            }else{
                $datas['bao']=$request->post('bao');
            }

            if(!$request->post('piao')){
                $datas['piao']=0;
            }else{
                $datas['piao']=$request->post('piao');
            }
            if(!$request->post('zhun')){
                $datas['zhun']=0;
            }else{
                $datas['zhun']=$request->post('zhun');
            }
            $datas['start_send']=$request->post('start_send');
            $datas['send_cost']=$request->post('send_cost');
            $datas['notice']=$request->post('notice');
            $datas['discount']=$request->post('discount');
            $shop->update($datas);
            $request->session()->flash("success","编辑成功");
            return redirect()->route("user.index");
        }
        return view("shop.user.edit",compact('shop','cates'));
    }


    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            //健壮性
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required',
            ]);



            if (Auth::attempt(['name'=>$request->post('name'),'password'=>$request->post('password')],$request->has('remember'))) {

                if (Auth::user()->status===0) {
                    Auth::logout();
                    return redirect()->route('user.login')->with('danger',"您登陆的商家商户已被禁用");
                }
                //提示
                $request->session()->flash("success","登录成功");
                //跳转
                return redirect()->route('user.index');

            }else{
                //提示
                $request->session()->flash("danger","账号或密码错误");
                //跳转
                return redirect()->back()->withInput();
            }
        }
        return view("shop.user.login");
    }
    public function logout()
    {

        Auth::logout();
        //提示
        session()->flash("danger","注销成功");
        return redirect()->route("user.login");
    }
}
