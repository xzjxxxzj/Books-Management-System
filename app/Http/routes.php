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

//后台登录
Route::get('admin/login', 'Admin\LoginController@adminLogin');
Route::get('admin/loginOut', 'Admin\LoginController@loginOut');

Route::post('admin/doLogin', 'Admin\LoginController@doLogin');

//后台页面
Route::get('admin/home', 'Admin\IndexController@home');