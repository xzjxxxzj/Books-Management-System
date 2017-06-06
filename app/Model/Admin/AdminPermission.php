<?php

/**
 * @author dazhen
 * @example 用于管理员后台权限判断
 */

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Admin\AdminSession;
use Illuminate\Http\Request;

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
            $jurisdiction = objectToArray($jurisdiction);
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

    public function isPermission($url)
    {
        //待完善
        return true;

        if (empty($url)) {
            return false;
        }
        if ($this->userInfo['userGroup'] == '1') {
            return true;
        }
        $pageId = DB::table('admin_menu')
                  ->where('url', $url)
                  ->get();
        if (!$pageId) {
            return false;
        }
        $userPer = $this->getUserJurisdiction();
        if (!in_array($pageId, $userPer['data'])) {
            return false;
        }
        return true;
    }

    /**
     * 获取左侧菜单
     */

    public function getMenu()
    {
        $menu = array();
        $userPer = $this->getUserJurisdiction();
        //获取需要显示的项目
        $menuList = DB::table('admin_menu')
                    ->where('show', '1')
                    ->orderBy('sort', 'desc')
                    ->get();
        if ($menuList) {
            $menuList = objectToArray($menuList);
            //获取项目列表
            $menuName = array();
            foreach ($menuList as $key => $value) {
                if ($value['parentId'] == '0') {
                    $menu["{$value['id']}"] = array();
                    $menuName["{$value['id']}"] = $value['name'];
                    unset($menuList["$key"]);
                }
            }
            //获取项目子项目
            foreach ($menuList as $value) {
                if (!isset($menu["{$value['parentId']}"]) || $this->userInfo['userGroup'] != '1' && !in_array($value['id'], $userPer['data'])) {
                    continue;
                }
                $menu["{$value['parentId']}"][] = $value;
            }
            $menu = array_combine($menuName, $menu);
            //去掉空项目
            foreach ($menu as $key => $value) {
                if (empty($value)) {
                    unset($menu["$key"]);
                }
            }
        }
        $sysMenu = $this->sysMenu($this->userInfo);
        $menu = $sysMenu + $menu;
        return array('code' => '1', 'data' => $menu);
    }

    /**
     * 判断显示哪个菜单
     * 默认显示 系统设置
     */
    public function showTitle()
    {
        $path = trim($_SERVER['REQUEST_URI'],'/');
        if ($path == 'admin') {
            return '';
        }
        $pathArray = explode('/', $path);
        if (count($pathArray) > 3) {
            $path = $pathArray['0'] . '/' . $pathArray['1'] . '/' . $pathArray['2'];
        }
        $parentId = DB::table('admin_menu')
                  ->where('url', $path)
                  ->value('parentId');
        if ($parentId) {
            $name = DB::table('admin_menu')
                      ->where('id', $parentId)
                      ->value('name');
            return $name;
        }
        return '系统设置';
    }

    /**
     * 系统菜单
     */

    private function sysMenu($userInfo)
    {
        if (!$userInfo) {
            return false;
        }
        if ($userInfo['userGroup'] == '1') {
            $sysMenu = [
                '系统设置' => [
                    [
                        'name' => '修改密码',
                        'url' => 'admin/resetPassword',
                    ],
                    [
                        'name' => '用户管理',
                        'url' => 'admin/adminUser',
                    ],
                    [
                        'name' => '用户组管理',
                        'url' => 'admin/adminGroup',
                    ],
                    [
                        'name' => '商店管理',
                        'url' => 'admin/shop',
                    ],
                    [
                        'name' => '项目添加',
                        'url' => 'admin/addProject',
                    ],
                    [
                        'name' => '登陆日志',
                        'url' => 'admin/loginLog',
                    ]
                ],
            ];
        } elseif ($userInfo['groupLeader'] == '1') {
            $sysMenu = [
                '系统设置' => [
                    [
                        'name' => '修改密码',
                        'url' => 'admin/resetPassword',
                    ],
                    [
                        'name' => '用户管理',
                        'url' => 'admin/adminUser',
                    ],
                ],
            ];
        } else {
            $sysMenu = [
                '系统设置' => [
                    [
                        'name' => '修改密码',
                        'url' => 'admin/resetPassword',
                    ],
                ],
            ];
        }
        return $sysMenu;
    }
}
