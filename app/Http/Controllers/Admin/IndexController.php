<?php

/**
 * @author dazhen
 * @example 用于后台首页
 */

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Model;
use App\Http\Requests;

class IndexController extends Controller
{
    private $userInfo;
    private $permission;

    public function __construct()
    {
        $user = Model\Admin\AdminSession::getAdminInfo('AdminInfo');
        if (!$user)
        {
            header ( "Location: " . url('admin/login'));
            die();
        }
        $this->userInfo = $user;
        $this->permission = new Model\Admin\AdminPermission();
    }

    public function home()
    {
        if (!$this->permission->isPermission('admin\home')) {
            jumpPage(true, '您没有权限！', array('返回' => url('admin/home')));
        }
        $data['menu'] = $this->permission->getMenu();
        return view('admin.home');
    }
}

