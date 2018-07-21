<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//关于我们
Route::get('/about', function () {
    return view('about');
})->name("about");
//帮助
Route::get('/help', function () {
    return view('help');
})->name("help");

//平台
Route::domain('admin.blm.com')->namespace('Admin')->group(function () {
    //店铺分类
    Route::any('shop_category/index',"ShopCategoryController@index")->name("shop_category.index");
    Route::any('shop_category/add',"ShopCategoryController@add")->name("shop_category.add");
    Route::any('shop_category/edit/{id}',"ShopCategoryController@edit")->name("shop_category.edit");
    Route::any('shop_category/del/{id}',"ShopCategoryController@del")->name("shop_category.del");
    //商家账户
    Route::any('user/index',"UserController@index")->name("user.index");
    Route::any('user/add',"UserController@add")->name("user.add");
    Route::any('user/edit/{id}',"UserController@edit")->name("user.edit");
    Route::any('user/del/{id}',"UserController@del")->name("user.del");
});

//商家
Route::domain('shop.blm.com')->namespace('Shop')->group(function () {
    //商家信息
    Route::any('shop/index',"ShopController@index")->name("shop.index");
    Route::any('shop/reg',"ShopController@reg")->name("shop.reg");
    Route::any('shop/edit/{id}',"ShopController@edit")->name("shop.edit");
    Route::any('shop/del/{id}',"ShopController@del")->name("shop.del");
});