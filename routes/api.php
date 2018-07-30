<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::namespace('Api')->group(function () {
    // 在 "App\Http\Controllers\Api" 命名空间下的控制器
    //店铺
    Route::get("shop/list","ShopController@list");
    Route::get("shop/index","ShopController@index");

    //用户
    Route::post("member/reg","MemberController@reg");
    Route::any("member/sms","MemberController@sms");
    Route::any("member/login","MemberController@login");
    Route::any("member/reset","MemberController@reset");

    //地址
    Route::any("addresses/add","AddressesController@add");
    Route::any("addresses/list","AddressesController@list");
    Route::any("addresses/save","AddressesController@save");
    Route::any("addresses/edit","AddressesController@edit");

    //购物车
    Route::any("cart/add","CartController@add");
    Route::any("cart/list","CartController@list");
});