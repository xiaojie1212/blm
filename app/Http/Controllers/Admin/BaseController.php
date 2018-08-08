<?php
/**
 * Created by PhpStorm.
 * User: XiaoJie
 * Date: 2018/7/22
 * Time: 14:04
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Closure;
class BaseController extends Controller
{
    public function __construct()
    {
        //添加保安 验证登录
        $this->middleware('auth:admin',[
            'except'=>['login'],
        ]);
        //再添加一个 login只有guest才能访问
        $this->middleware("guest:admin",[
            'only'=>['login']
        ]);

        //在这里判断用户有没有权限
        $this->middleware(function ($request, Closure $next) {

            $admin = Auth::guard('admin')->user();
            //判断当前路由在不在这个数组里，不在的话才验证权限，在的话不验证
            if (!in_array(Route::currentRouteName(), ['admin.login', 'admin.logout']) && Auth::guard('admin')->user()->id !==10) {
                //判断当前用户有没有权限访问 路由名称就是权限名称
                if ($admin->can(Route::currentRouteName()) === false) {
                    //显示视图
                    exit(view('admin.gun'));
                }
            }
            return $next($request);
        });

    }
}