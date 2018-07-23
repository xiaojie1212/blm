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
    //商家信息
    Route::any('shop/index',"ShopController@index")->name("shop.index");
    Route::any('shop/reg',"ShopController@reg")->name("shop.reg");
    Route::any('shop/edit/{id}',"ShopController@edit")->name("shop.edit");
    Route::any('shop/del/{id}',"ShopController@del")->name("shop.del");
    Route::any('shop/audit/{id}',"ShopController@audit")->name("shop.audit");
    //平台账户
    Route::any('admin/index',"AdminController@index")->name("admin.index");
    Route::any('admin/add',"AdminController@add")->name("admin.add");
    Route::any('admin/edit/{id}',"AdminController@edit")->name("admin.edit");
    Route::any('admin/del/{id}',"AdminController@del")->name("admin.del");
    Route::any('admin/login',"AdminController@login")->name("admin.login");
    Route::any('admin/logout',"AdminController@logout")->name("admin.logout");
    Route::any('admin/userIndex',"AdminController@userIndex")->name("admin.userIndex");
    Route::any('admin/audit/{id}',"AdminController@audit")->name("admin.audit");
    Route::any('admin/reset/{id}',"AdminController@reset")->name("admin.reset");
});

//商家
Route::domain('shop.blm.com')->namespace('Shop')->group(function () {

    //商家账户
    Route::any('user/index',"UserController@index")->name("user.index");
    Route::any('user/add',"UserController@add")->name("user.add");
    Route::any('user/edit/{id}',"UserController@edit")->name("user.edit");
    Route::any('user/del/{id}',"UserController@del")->name("user.del");
    Route::any('user/login',"UserController@login")->name("user.login");
    Route::any('user/logout',"UserController@logout")->name("user.logout");

    //菜品分类
    Route::any('menucate/index',"MenuCateController@index")->name("menucate.index");
    Route::any('menucate/add',"MenuCateController@add")->name("menucate.add");
    Route::any('menucate/edit/{id}',"MenuCateController@edit")->name("menucate.edit");
    Route::any('menucate/del/{id}',"MenuCateController@del")->name("menucate.del");
    //菜品分类
    Route::any('menu/index',"MenuController@index")->name("menu.index");
    Route::any('menu/add',"MenuController@add")->name("menu.add");
    Route::any('menu/edit/{id}',"MenuController@edit")->name("menu.edit");
    Route::any('menu/del/{id}',"MenuController@del")->name("menu.del");
});