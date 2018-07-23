<?php
/**
 * Created by PhpStorm.
 * User: XiaoJie
 * Date: 2018/7/22
 * Time: 14:04
 */

namespace App\Http\Controllers\Shop;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        //添加保安 验证登录
        $this->middleware('auth',[
            'except'=>['login'],
        ]);
        //再添加一个 login只有guest才能访问
        $this->middleware("guest",[
            'only'=>['login']
        ]);
    }
}