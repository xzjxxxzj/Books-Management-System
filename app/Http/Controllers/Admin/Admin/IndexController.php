<?php

/**
 * @author dazhen
 * @example 用于后台首页
 */

namespace App\Http\Controllers\Admin\Admin;

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
        $menu = $this->permission->getMenu();
        $data['menu'] = $menu['data'];
        return view('admin.admin.home', $data);
    }

    /**
     * 修改后台用户密码
     */

    public function resetPassword()
    {
        return view('admin.admin.resetPassword');
    }

    /**
     * 修改密码信息提交控制器
     */

    public function setPassword(Requests\Admin\Admin\AdminSetPasswordRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $reset = $sysLogic->resetPassword($request->all(), $this->userInfo);
        if ($reset['code'] == '1') {
            return jumpPage(true, array('修改成功' => '修改登陆密码成功！'), array('返回' => url('admin')));
        }
        return jumpPage(false, array('修改失败' => $reset['msg']), array('返回' => url('admin/resetPassword')));
    }

    /**
     * 用户管理列表
     */

    public function adminUserList()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $userList = $sysLogic->getUserList($this->userInfo);
        if ($userList['code'] != '1') {
            return jumpPage(false, array('打开失败' => $userList['msg']), array('返回' => url('admin')));
        }
        $data['userList'] = $userList['data'];
        return view('admin.admin.adminUser', $data);
    }

    /**
     * 添加管理用户
     */

    public function addUser()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $info = $sysLogic->addUser($this->userInfo);
        if ($info['code'] != '1') {
            return jumpPage(false, array('打开失败' => $info['msg']), array('返回' => url('admin')));
        }
        $data['group'] = $info['data']['groupInfo'];
        $data['shop'] = $info['data']['shopInfo'];
        $data['userInfo'] = $this->userInfo;
        return view('admin.admin.addUser', $data);
    }

    /**
     * 添加用户信息提交控制器
     */

    public function setAddUser(Requests\Admin\Admin\AdminSetAddUserRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $reset = $sysLogic->setAddUser($request->all(), $this->userInfo);
        if ($reset['code'] == '1') {
            return jumpPage(true, array('添加成功' => '添加用户成功！'), array('返回' => url('admin')));
        }
        return jumpPage(false, array('添加失败' => $reset['msg']), array('返回' => url('admin/addUser')));
    }

    /**
     * 启用或者弃用用户
     * @param int $userId 用户ID
     * @param int $status 状态 0：启用  1：弃用
     */

    public function enableUser($userId, $status)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $set = $sysLogic->enableUser($userId, $status, $this->userInfo);
        if ($set['code'] == '1') {
            return jumpPage(true, array('操作成功' => '操作成功！'), array('返回' => url('admin/adminUser')));
        }
        return jumpPage(false, array('操作失败' => $set['msg']), array('返回' => url('admin/adminUser')));
    }

    /**
     * 锁定用户IP地址
     * @param int $userId
     */

    public function lockIp($userId)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $lockUser = $sysLogic->lockUserInfo($userId, $this->userInfo);
        if ($lockUser['code'] != '1') {
            return jumpPage(false, array('打开失败' => $lockUser['msg']), array('返回' => url('admin/adminUser')));
        }
        $data['userInfo'] = $lockUser['data'];
        return view('admin.admin.lockIp', $data);
    }

    /**
     * 锁定用户IP提交控制器
     */

    public function lockUser(Requests\Admin\Admin\AdminLockUserRequest $request)
    {
        $postData = $request->all();
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $lockUser = $sysLogic->lockUser($postData, $this->userInfo);
        if ($lockUser['code'] != '1') {
            return jumpPage(false, array('操作失败' => $lockUser['msg']), array('返回' => url('admin/lockIp/' . $postData['userId'])));
        }
        return jumpPage(true, array('操作成功' => '更新用户IP成功！'), array('返回' => url('admin/lockIp/' . $postData['userId'])));
    }

    /**
     * 重置用户密码
     */

    public function resetKey($userId)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $lockUser = $sysLogic->resetKey($userId, $this->userInfo);
        if ($lockUser['code'] != '1') {
            return jumpPage(false, array('打开失败' => $lockUser['msg']), array('返回' => url('admin/adminUser')));
        }
        $data['userInfo'] = $lockUser['data'];
        return view('admin.admin.resetKey', $data);
    }

    /**
     * 重置用户密码信息提交控制器
     */

    public function resetUserKey(Requests\Admin\Admin\AdminResetKeyRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $reset = $sysLogic->resetUserKey($request->all(), $this->userInfo);
        if ($reset['code'] == '1') {
            return jumpPage(true, array('修改成功' => '修改登陆密码成功！'), array('返回' => url('admin/adminUser')));
        }
        return jumpPage(false, array('修改失败' => $reset['msg']), array('返回' => url('admin/adminUser')));
    }

    /**
     * 用户组列表
     */

    public function adminGroup()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $groupList = $sysLogic->adminGroup($this->userInfo);
        if ($groupList['code'] != '1') {
            return jumpPage(false, array('打开失败' => $groupList['msg']), array('返回' => url('admin')));
        }
        $data['groupList'] = $groupList['data'];
        return view('admin.admin.adminGroup', $data);
    }

    /**
     * 添加用户组
     */

    public function addUserGroup()
    {
        if ($this->userInfo['userGroup'] != '1') {
            return jumpPage(false, array('打开失败' => '您没有权限！'), array('返回' => url('admin')));
        }
        return view('admin.admin.addUserGroup');
    }

    /**
     * 添加用户组信息提交控制器
     */

    public function setAddUserGroup(Requests\Admin\Admin\AdminSetAddGroupRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $addGroup = $sysLogic->addUserGroup($request->all(), $this->userInfo);
        if ($addGroup['code'] != '1') {
            return jumpPage(false, array('添加失败' => $addGroup['msg']), array('返回' => url('admin')));
        }
        return jumpPage(true, array('添加成功' => '添加用户组成功！'), array('返回' => url('admin/adminGroup')));
    }

    /**
     * 设置用户组
     */

    public function setUserGroup($groupId)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $groupInfo = $sysLogic->getGroupInfo($groupId, $this->userInfo);
        if ($groupInfo['code'] != '1') {
            return jumpPage(false, array('打开失败' => $groupInfo['msg']), array('返回' => url('admin')));
        }
        $data['groupInfo'] = $groupInfo['data'];
        return view('admin.admin.setUserGroup', $data);
    }

    /**
     * 修改用户组信息提交控制器
     */

    public function updateGroup(Requests\Admin\Admin\AdminUpdateGroupRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $updateGroup = $sysLogic->updateGroup($request->all(), $this->userInfo);
        if ($updateGroup['code'] != '1') {
            return jumpPage(false, array('修改失败' => $updateGroup['msg']), array('返回' => url('admin')));
        }
        return jumpPage(true, array('修改成功' => '修改用户组成功！'), array('返回' => url('admin/adminGroup')));
    }

    /**
     * 商店列表
     */

    public function shop()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $groupList = $sysLogic->adminShop($this->userInfo);
        if ($groupList['code'] != '1') {
            return jumpPage(false, array('打开失败' => $groupList['msg']), array('返回' => url('admin')));
        }
        $data['shopList'] = $groupList['data'];
        return view('admin.admin.adminShop', $data);
    }

    /**
     * 添加用户组
     */

    public function addShop()
    {
        if ($this->userInfo['userGroup'] != '1') {
            return jumpPage(false, array('打开失败' => '您没有权限！'), array('返回' => url('admin')));
        }
        return view('admin.admin.addShop');
    }

    /**
     * 添加用户组信息提交控制器
     */

    public function setAddShop(Requests\Admin\Admin\AdminSetAddShopRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $addShop = $sysLogic->addShop($request->all(), $this->userInfo);
        if ($addShop['code'] != '1') {
            return jumpPage(false, array('添加失败' => $addShop['msg']), array('返回' => url('admin')));
        }
        return jumpPage(true, array('添加成功' => '添加商店成功！'), array('返回' => url('admin/shop')));
    }

    /**
     * 设置用户组
     */

    public function setShop($groupId)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $shopInfo = $sysLogic->getShopInfo($groupId, $this->userInfo);
        if ($shopInfo['code'] != '1') {
            return jumpPage(false, array('打开失败' => $shopInfo['msg']), array('返回' => url('admin')));
        }
        $data['shopInfo'] = $shopInfo['data'];
        return view('admin.admin.setShop', $data);
    }

    /**
     * 修改用户组信息提交控制器
     */

    public function updateShop(Requests\Admin\Admin\AdminUpdateShopRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $updateShop = $sysLogic->updateShop($request->all(), $this->userInfo);
        if ($updateShop['code'] != '1') {
            return jumpPage(false, array('修改失败' => $updateShop['msg']), array('返回' => url('admin')));
        }
        return jumpPage(true, array('修改成功' => '修改商店成功！'), array('返回' => url('admin/shop')));
    }

    /**
     * 添加项目控制器
     */

    public function addProject()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $menu = $sysLogic->getMenu($this->userInfo);
        if ($menu['code'] != '1') {
            return jumpPage(false, array('打开失败' => $menu['msg']), array('返回' => url('admin')));
        }
        $data['menu'] = $menu['data'];
        return view('admin.admin.addProject', $data);
    }

    /**
     * 添加项目信息提交控制器
     */

    public function setAddProject(Requests\Admin\Admin\AdminAddProjectRequest $request)
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $updateShop = $sysLogic->addProject($request->all(), $this->userInfo);
        if ($updateShop['code'] != '1') {
            return jumpPage(false, array('添加失败' => $updateShop['msg']), array('返回' => url('admin')));
        }
        return jumpPage(true, array('添加成功' => '添加项目成功！'), array('返回' => url('admin')));
    }

    /**
     * 登录日志
     */

    public function loginLog()
    {
        $sysLogic = new Model\Admin\Admin\AdminSysSet();
        $logList = $sysLogic->getLoginLog($this->userInfo);
        if ($logList['code'] != '1') {
            return jumpPage(false, array('打开失败' => $logList['msg']), array('返回' => url('admin')));
        }
        $data['list'] = $logList['data'];
        return view('admin.admin.loginLog', $data);
    }
}

