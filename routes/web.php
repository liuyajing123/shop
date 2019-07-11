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

Route::get('/admin/add_goods','admin\GoodsController@add_goods');
Route::post('/admin/do_add_goods','admin\GoodsController@do_add_goods');
Route::prefix('/admin/student/')->group(function() {
    Route::get('add','Admin\studentController@add');
    Route::get('do_add','Admin\studentController@do_add');
    Route::get('index','Admin\studentController@index');
    Route::get('edit/{id}','Admin\studentController@edit');
    Route::get('update','Admin\studentController@update');
    Route::get('delete/{id}','Admin\studentController@delete');
});
// 登录
Route::get('/Student/login', 'StudentController@login');
Route::post('/Student/do_login', 'StudentController@do_login');
// 调用中间件
Route::group(['middleware' => ['login']], function () {
    // 学生添加
    Route::get('/Student/add', 'StudentController@add');
});
// 后台
Route::prefix('/admin/login/')->group(function() {
    Route::get('login','Admin\loginController@login');
    Route::get('register','Admin\loginController@register');
    Route::post('do_login','Admin\loginController@do_login');
    Route::post('do_register','Admin\loginController@do_register');
});
// 前台
Route::prefix('/')->group(function() {
    Route::any('/','Index\indexController@index');
    Route::any('/index/login/login','Index\loginController@login');
    Route::get('/index/login/register','Index\loginController@register');
    Route::any('/index/login/do_login','Index\loginController@do_login');
    Route::post('/index/login/do_register','Index\loginController@do_register');
});
//商品图片上传
Route::prefix('/admin/goods/')->group(function() {
    Route::get('add','Admin\goodsController@add');
    Route::post('do_add','Admin\goodsController@do_add');
});