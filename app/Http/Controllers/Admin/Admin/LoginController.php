<?php

/**
 * @author dazhen
 * @example 用于管理员登陆
 */

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Model;
use App\Http\Requests;

class LoginController extends Controller
{
    
    /**
     * 登录控制器
     */
    
    public function adminLogin()
    {
        $user = Model\Admin\AdminSession::getAdminInfo('AdminInfo');
        if(!$user) {
            return view('admin.admin.login');
        } else {
            return redirect('admin');
        }
    }

    /**
     * 登录信息提交控制器
     */

    public function doLogin(Requests\Admin\Admin\AdminLoginRequest $request)
    {
        $user = Model\Admin\AdminSession::getAdminInfo('AdminInfo');
        if($user) {
            return redirect('admin');
        }
        $logic = new Model\Admin\Admin\AdminLogin();
        $login = $logic->userLogin($request->all());
        if ($login['code'] == '1') {
            return redirect('admin');
        } else {
            return jumppage(false, array('登陆失败' => $login['msg']), array('返回' => url('admin/login')));
        }
    }

    /**
     *  退出登录
     */

    public function loginOut()
    {
        Model\Admin\AdminSession::clearAdminInfo();
        return redirect('admin/login');
    }

}
