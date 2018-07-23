<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShopController extends Controller
{
    public function index()
    {
        $shops=Shop::paginate(3);
        return view('admin.shop.index',compact('shops'));
    }

    public function reg(Request $request)
    {
        $cates=ShopCategory::where('status','1')->get();
        if ($request->isMethod('post')){
            //验证
            $this->validate($request,[
                "name" => "required|min:2",
                "password" => "required",
                "email" => "required|email",
                "shop_name" => "required|min:2",
                "start_send" => "required",
                "send_cost" => "required",
            ]);
            DB::transaction(function () use ($request){

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

                if ($shop=Shop::create($datas)) {
                    $data['name']=$request->post('name');
                    $data['password']=bcrypt($request->post('password'));
                    $data['email']=$request->post('email');
                    $data['shop_id']=$shop['id'];
                    User::create($data);
                }
            });
            $request->session()->flash("success","注册成功,等待管理员审核");
            return redirect()->route("shop.index");


        }
        return view("admin.shop.reg",compact("cates"));
    }

    public function edit(Request $request,$id)
    {
//        找到数据
        $cates=ShopCategory::all();
        $shop=Shop::findOrFail($id);
        $user=User::where('shop_id',$id)->first();
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
            $data['password']=bcrypt($request->post('password'));
            $data['email'] = $request->post('email');
            if ($user->update($data)) {
                $date['shop_name'] = $request->post('shop_name');
                $date['shop_category_id'] = $request->post('shop_category_id');
                $date['img']="";
                if ($request->file('img')){
                    //上传图片
                    File::delete(public_path("/uploads/".$shop->img));
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
        return view("admin.shop.edit",compact("cates","shop","user"));
    }

    public function del(Request $request,$id)
    {
        DB::transaction(function () use ($id){
           $shop= Shop::findOrFail($id)->delete();
           File::delete(public_path("/uploads/".$shop->img));
           $user=User::where('shop_id',$id)->delete();
        });
        return redirect()->route('shop.index')->with('success','删除成功');
    }

    public function audit($id)
    {
        $shop=Shop::findOrFail($id);
        $shop->status=1;
        $shop->save();
        return back()->with("success","通过审核");
    }

}
