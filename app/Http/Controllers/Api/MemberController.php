<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Mrgoon\AliSms\AliSms;

class MemberController extends BaseController
{
    //注册
    public function reg(Request $request)
    {

        //接受参数
        $data=$request->all();
        $validator = Validator::make($data, [
            'username' => 'required|unique:members',
            'sms' => 'required|integer|min:1000|max:9999',
            'tel'=>[
                'required',
                'regex:/^0?(13|14|15|17|18|19)[0-9]{9}$/',
                'unique:members',
            ],
            'password'=>'required|min:6'
        ]);

        if ($validator->fails()) {
            return [
                'status' => "false",
                //获取错误信息
                "message" => $validator->errors()->first()
            ];
        }
        //验证验证码是否一致
        $code = Redis::get("tel_" . $data['tel']);
        if ($code != $data['sms']) {
            //返回错误
            return [
                'status' => "false",
                //获取错误信息
                "message" => "验证码错误"
            ];
        }
        $data['password']=bcrypt($data['password']);
        //录入数据库
        Member::create($data);
        return [
            'status'=>"true",
            'message'=>"注册成功"
        ];

    }
    //发短信
    public function sms()
    {
        //接收手机号
        $tel=\request()->input('tel');
        //生成随机验证码
        $code=rand(1000,9999);
        //保存验证码并设置过期时间为五分钟
        cache([$tel => $code], 5);

        $config = [
            'access_key' => 'LTAIrGYffYL2khhY',
            'access_secret' => 'J9LzDSH0R0WzbICjKzmV257xZmcP26',
            'sign_name' => '杜连杰',
        ];
        $aliSms=new AliSms();
        //调用接口发送短信
        $response = $aliSms->sendSms($tel, 'SMS_140690138', ['code'=> $code], $config);
        if($response->Message==="OK"){
            //成功
            return [
                "status"=>"true",
                "message"=>"获取短信验证码成功"
            ];
        }else{
            //失败
            return [
                "status"=>"false",
                "message"=>$response->Message
            ];
        }
    }
   //登录
    public function login(Request $request)
    {
        //接受参数
        $data=$request->all();

        $member = Member::where("username","{$data['name']}")->first();
        //验证密码是否一致
        if ($member && Hash::check($data['password'], $member->password)) {
            return [
                'status' => 'true',
                'message' => '登录成功',
                'user_id'=>$member->id,
                'username'=>$member->username
            ];
        }else{
            return [
                'status' => 'false',
                'message' => '账号或密码错误'
            ];
        }
    }

    public function reset(Request $request)
    {
        $data=$request->all();
        $member=Member::where('tel',"{$data['tel']}")->first();
        if(!$member){
            return [
                'status' => "false",
                //获取错误信息
                "message" => "电话号码错误"
            ];
        }
        //验证验证码是否一致
        $code = Redis::get("tel_" . $data['tel']);
        if ($code != $data['sms']) {
            //返回错误
            return [
                'status' => "false",
                //获取错误信息
                "message" => "验证码错误"
            ];
        }
        $data['password']=bcrypt($data['password']);
        $member->update($data);
        return [
            'status'=>"true",
            'message'=>"重置密码成功"
        ];
    }

    public function detail(Request $request)
    {
        $userId=$request->input('user_id');
        return Member::find($userId);
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $member = Member::find($data['id']);
        if ($member && Hash::check($data['oldPassword'], $member->password)) {
            $data['password'] = Hash::make($data['newPassword']);
            $member->update($data);
            return [
                'status'=>"true",
                'message'=>"修改密码成功"
            ];
        }else{
            return [
                'status' => "false",
                //获取错误信息
                "message" => "旧密码错误"
            ];
        }
    }

}
