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
    return view('index');
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
    Route::any('shop/upload',"ShopController@upload")->name("shop.upload");

    //平台账户
    Route::any('admin/index',"AdminController@index")->name("admin.index");
    Route::any('admin/add',"AdminController@add")->name("admin.add");
    Route::any('admin/edit/{id}',"AdminController@edit")->name("admin.edit");
    Route::any('admin/editRole/{id}',"AdminController@editRole")->name("admin.editRole");
    Route::any('admin/del/{id}',"AdminController@del")->name("admin.del");
    Route::any('admin/login',"AdminController@login")->name("admin.login");
    Route::any('admin/logout',"AdminController@logout")->name("admin.logout");
    Route::any('admin/userIndex',"AdminController@userIndex")->name("admin.userIndex");
    Route::any('admin/audit/{id}',"AdminController@audit")->name("admin.audit");
    Route::any('admin/reset/{id}',"AdminController@reset")->name("admin.reset");

    //活动信息
    Route::any('activity/index',"ActivityController@index")->name("activity.index");
    Route::any('activity/add',"ActivityController@add")->name("activity.add");
    Route::any('activity/edit/{id}',"ActivityController@edit")->name("activity.edit");
    Route::any('activity/del/{id}',"ActivityController@del")->name("activity.del");

    //订单
    Route::any('order/index',"OrderController@index")->name("orders.index");
    Route::any('order/day',"OrderController@day")->name("orders.day");
    Route::any('order/month',"OrderController@month")->name("orders.month");
    Route::any('order/menuDay',"OrderController@menuDay")->name("orders.menuDay");
    Route::any('order/menuMonth',"OrderController@menuMonth")->name("orders.menuMonth");

    //权限
    Route::any('per/index',"PerController@index")->name("per.index");
    Route::any('per/add',"PerController@add")->name("per.add");
    Route::any('per/del/{id}',"PerController@del")->name("per.del");

    //角色
    Route::any('role/index',"RoleController@index")->name("role.index");
    Route::any('role/add',"RoleController@add")->name("role.add");
    Route::any('role/edit/{id}',"RoleController@edit")->name("role.edit");    Route::any('role/del/{id}',"RoleController@del")->name("role.del");

    //导航
    Route::any('nav/index',"NavController@index")->name("nav.index");
    Route::any('nav/add',"NavController@add")->name("nav.add");
    Route::any('nav/edit/{id}',"NavController@edit")->name("nav.edit");       Route::any('nav/del/{id}',"NavController@del")->name("nav.del");

    //抽奖活动
    Route::any('event/index',"EventController@index")->name("event.index");
    Route::any('event/add',"EventController@add")->name("event.add");
    Route::any('event/edit/{id}',"EventController@edit")->name("event.edit");
    Route::any('event/del/{id}',"EventController@del")->name("event.del");
    Route::any('event/bonus/{id}',"EventController@bonus")->name("event.bonus");
    Route::any('event/list/{id}',"EventController@list")->name("event.list");
    Route::any('event/prizeList/{id}',"EventController@prizeList")->name("event.prizeList");

    //奖品
    Route::any('eventPrize/index',"EventPrizeController@index")->name("eventPrize.index");
    Route::any('eventPrize/add',"EventPrizeController@add")->name("eventPrize.add");
    Route::any('eventPrize/edit/{id}',"EventPrizeController@edit")->name("eventPrize.edit");
    Route::any('eventPrize/del/{id}',"EventPrizeController@del")->name("eventPrize.del");
    Route::any('eventPrize/winner/{id}',"EventPrizeController@winner")->name("eventPrize.winner");
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
    Route::any('user/act',"UserController@act")->name("user.act");

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
    Route::any('menu/upload',"MenuController@upload")->name("menu.upload");

    //订单
    Route::any('order/index',"OrderController@index")->name("order.index");
    Route::any('order/detail/{id}',"OrderController@detail")->name("order.detail");
    Route::any('order/audit/{id}',"OrderController@audit")->name("order.audit");
    Route::any('order/cancel/{id}',"OrderController@cancel")->name("order.cancel");
    Route::any('order/day',"OrderController@day")->name("order.day");
    Route::any('order/month',"OrderController@month")->name("order.month");
    Route::any('order/menuDay',"OrderController@menuDay")->name("order.menuDay");
    Route::any('order/menuMonth',"OrderController@menuMonth")->name("order.menuMonth");

    //报名
    Route::any('events/index',"EventController@index")->name("events.index");
    Route::any('events/signUp/{id}',"EventController@signUp")->name("events.signUp");
    Route::any('events/winner',"EventController@winner")->name("events.winner");
});