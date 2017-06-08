<?php

/**
 * @author dazhen
 * @example 用于用户管理
 */

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Model;
use App\Http\Requests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userInfo;
    private $permission;

    public function __construct(Request $request)
    {
        $user = Model\Admin\AdminSession::getAdminInfo('AdminInfo');
        if (!$user)
        {
            header ( "Location: " . url('admin/login'));
            die();
        }
        $this->userInfo = $user;
        $this->permission = new Model\Admin\AdminPermission();
        if (!$this->permission->isPermission($request->path())) {
            echo jumppage(false, array('打开失败' => '您没有权限！'), array('返回' => url('admin')));
            exit;
        }
    }

    /**
     * 用户列表
     */

    public function userList(Requests\Admin\User\UserGetListRequest $request)
    {
        $userLogic = new Model\Admin\User\UserLogic();
        $userList = $userLogic->getUserList($request->all());
        return view('admin.user.userList', $userList['data']);
    }

    /**
     * 用户借书
     */

    public function borrowBook(Requests\Admin\User\UserBorrowBookRequest $request)
    {
        $userLogic = new Model\Admin\User\UserLogic();
        $borrow = $userLogic->borrowBook($request->all());
        if ($borrow['code'] != '1') {
            return jumpPage(false, array('借书失败' => $borrow['msg']), array('返回' => url('admin/user/userList')));
        }
        return jumpPage(true, array('借书成功' => '借书成功！'), array('返回' => url('admin/user/userList')));
    }

    /**
     * 用户借书列表
     */

    public function borrowList(Requests\Admin\User\UserBorrowListRequest $request)
    {
        $userLogic = new Model\Admin\User\UserLogic();
        $borrowList = $userLogic->borrowList($request->all());
        return view('admin.user.borrowBookList', $borrowList['data']);
    }
}
