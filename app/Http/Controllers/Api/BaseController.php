<?php
/**
 * Created by PhpStorm.
 * User: XiaoJie
 * Date: 2018/7/22
 * Time: 14:04
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        //跨域
        header('Access-Control-Allow-Origin:*');
    }
}