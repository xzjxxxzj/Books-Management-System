<?php

/**
 * @author dazhen
 * @example 用于管理员后台权限判断
 */

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Admin\AdminSession;

class AdminPermission extends Model
{
    private $userInfo;

    function __construct()
    {
        $userInfo = AdminSession::getAdminInfo('AdminInfo');
        if (!$userInfo) {
            header ( "Location: " . url('admin/login'));
            die();
        }
        $this->userInfo = $userInfo;
    }

    /**
     * 获取用户权限
     * @param int $userId
     * @return array
     */

    public function getUserJurisdiction()
    {
        $jurisdiction = DB::table('admin_jurisdiction')
                    ->where('uid', $this->userInfo['userId'])
                    ->get();
        $userJurisdiction = array();
        if ($jurisdiction) {
            $jurisdiction = get_object_vars($jurisdiction);
            if ($jurisdiction['jurisdiction']) {
                $userJurisdiction = explode(',', trim($jurisdiction['jurisdiction'], ','));
            }
        }
        return array('code' => '1', 'data' => $userJurisdiction);
    }

    /**
     * 判断用户该页面是否有权限
     * @param str $namespace
     * @return bool
     */

    public function isPermission($namespace)
    {
        if (empty($namespace)) {
            return false;
        }
        if ($this->userInfo['userGroup'] == '1') {
            return true;
        }
        //待补充
        return true;
    }

    /**
     * 获取左侧菜单
     */

    public function getMenu()
    {
        $userPer = $this->getUserJurisdiction();

        $menuList = DB::table('admin_menu')
                    ->where('show', '1')
                    ->orderBy('sort', 'desc')
                    ->get();
        if (!$menuList) {
            return array('code' => '0', 'msg' => '没有显示的项目！');
        }
        $menuList = get_object_vars($menuList);

        //获取项目列表
        $menu = array();
        $menuName = array();
        foreach ($menuList as $key => $value) {
            if ($value['parentid'] == '0') {
                $menu["{$value['id']}"] = array();
                $menuName["{$value['id']}"] = $value['name'];
                unset($menuList["$key"]);
            }
        }

        //获取项目子项目
        foreach ($menuList as $value) {
            if (!isset($menu["{$value['parentid']}"]) || $this->userInfo['userGroup'] != '1' && !in_array($value['id'], $userPer)) {
                continue;
            }
            $menu["{$value['parentid']}"][] = $value;
        }
        $menu = array_combine($menuName, $menu);
        //去掉空项目
        foreach ($menu as $key => $value) {
            if (!empty($value)) {
                unset($menu["$key"]);
            }
        }
        return array('code' => '1', 'data' => $menu);
    }
}
