<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//前台路由
Route::any('/wechat', 'WechatController@serve');  //微信接口
Route::any('/wechat/menu_add', 'WechatController@menu_add');  //微信菜单

Route::group(['middleware' => ['wechat.oauth']], function () {
    Route::controller('user', 'UsersController');  //用户绑定
    Route::controller('activity', 'ActivityController');  //活动
    Route::controller('course', 'CourseController');  //公开课
    Route::controller('acticle', 'ActicleController');  //投稿
});



//后台路由
Route::controller('login','admin\LoginController');//后台登陆处理
Route::post('upload_image', 'admin\ActivityController@uploadImage')->name('activity.upload_image');//上传图片api
Route::group(['middleware'=>['auth']],function(){
    Route::controller('index','admin\IndexController');//后台首页（导航页）
    Route::controller('admin_activity','admin\ActivityController');//后台活动
    Route::controller('admin_acticle','admin\ActicleController');//后台稿件
    Route::controller('admin_user','admin\UserController');//后台小记者管理
    Route::controller('admin_class','admin\ClasssController');//后台学校管理
    Route::controller('admin_course','admin\CourseController');//后台学校管理
    Route::controller('admin_pay','admin\PayController');//后台支付管理
    Route::controller('admin_vip','admin\VipController');//后台会员价格管理
});

