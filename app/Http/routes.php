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

/**
 * 后台设置
 */
Route::group(['namespace' => 'Admin\Admin'], function()
{
    //用户登录
    Route::get('admin/login', 'LoginController@adminLogin');
    Route::post('admin/doLogin', 'LoginController@doLogin');
    //用户退出登录
    Route::get('admin/loginOut', 'LoginController@loginOut');

    //后台首页
    Route::get('admin', 'IndexController@home');
    //修改用户密码
    Route::get('admin/resetPassword', 'IndexController@resetPassword');
    Route::post('admin/setPassword', 'IndexController@setPassword');

    //用户列表
    Route::get('admin/adminUser', 'IndexController@adminUserList');
    //添加用户
    Route::get('admin/addUser', 'IndexController@addUser');
    Route::post('admin/setAddUser', 'IndexController@setAddUser');
    //恢复删除用户
    Route::get('admin/enableUser/{userId}/{status}', 'IndexController@enableUser')->where(['userId' => '[0-9]+', 'status' => '[0-1]']);
    //锁定用户IP地址
    Route::get('admin/lockIp/{userId}', 'IndexController@lockIp')->where('userId', '[0-9]+');
    Route::post('admin/lockUser', 'IndexController@lockUser');
    //修改组员密码
    Route::get('admin/resetKey/{userId}', 'IndexController@resetKey')->where('userId', '[0-9]+');
    Route::post('admin/resetUserKey', 'IndexController@resetUserKey');

    //用户组管理
    Route::get('admin/adminGroup', 'IndexController@adminGroup');
    Route::get('admin/addUserGroup', 'IndexController@addUserGroup');
    Route::post('admin/setAddUserGroup', 'IndexController@setAddUserGroup');
    Route::get('admin/setUserGroup/{groupId}', 'IndexController@setUserGroup')->where('groupId', '[0-9]+');
    Route::post('admin/updateGroup', 'IndexController@updateGroup');

    //商店管理
    Route::get('admin/shop', 'IndexController@shop');
    Route::get('admin/addShop', 'IndexController@addShop');
    Route::post('admin/setAddShop', 'IndexController@setAddShop');
    Route::get('admin/setShop/{shopId}', 'IndexController@setShop')->where('shopId', '[0-9]+');
    Route::post('admin/updateShop', 'IndexController@updateShop');

    //项目管理
    Route::get('admin/addProject', 'IndexController@addProject');
    Route::post('admin/setAddProject', 'IndexController@setAddProject');

    //登录日志
    Route::get('admin/loginLog', 'IndexController@loginLog');
});

/**
 * 后台图书管理
 */
Route::group(['namespace' => 'Admin\Book'], function()
{
    //图书列表
    Route::get('admin/book/bookList', 'BookController@bookList');
    Route::get('admin/book/addBook', 'BookController@addBook');
    //图书类别管理
    Route::get('admin/book/bookType', 'BookController@bookType');
    Route::get('admin/book/addBookType', 'BookController@addBookType');
    Route::post('admin/book/setAddBookType', 'BookController@setAddBookType');
    Route::get('admin/book/setBookType/{typeId}', 'BookController@setBookType')->where('typeId', '[0-9]+');
    Route::post('admin/book/updateBookType', 'BookController@updateBookType');
});