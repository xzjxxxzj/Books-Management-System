<?php

/**
 * @author dazhen
 * @example 用于系统设置模型编写
 */

namespace App\Model\Admin\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminSysSet extends Model
{

    /**
     * 修改密码
     * @param array $data
     * @param array $userInfo
     * @return array
     */

    public function resetPassword($data, $userInfo)
    {
        $user = DB::table('admin_user')
            ->where('id', $userInfo['userId'])
            ->first();
        $user = objectToArray($user);

        $oldPassword = md5(md5($user['passCode'] ) . md5($data['oldPassword']));
        if ($user['passWord'] != $oldPassword) {
            return array('code' => '0', 'msg' => '旧密码错误！', 'data' => '');
        }
        $passwordCode = str_random('6');
        $newPassword = md5(md5($passwordCode) . md5($data['passWord']));
        DB::table('admin_user')
            ->where('id', $userInfo['userId'])
            ->update(
                [
                    'errorNum' => '0',
                    'updateTime' => time(),
                    'passCode' => $passwordCode,
                    'passWord' => $newPassword
                ]
            );
        return array('code' => '1', 'msg' => '修改成功！', 'data' => '');
    }

    /**
     * 查询用户列表
     * @param array $userInfo
     * @return array
     */
    public function getUserList($userInfo)
    {
        $table = DB::table('admin_user');
        //管理员查询条件
        if ($userInfo['userGroup'] == '1') {
            $getUser = $table->paginate(10);
        } elseif ($userInfo['groupLeader'] == '1') {
            $getUser = $table->where(
                [
                    'group' => $userInfo['userGroup'],
                    'shopId' => $userInfo['shopId']
                ]
            )->paginate(10);
        } else {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $getUser);
    }

    /**
     * 添加用户 查询用户组 和店铺
     * @param array $userInfo
     * @return array
     */
    public function addUser($userInfo)
    {
        if ($userInfo['userGroup'] != '1' && $userInfo['groupLeader'] !='1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $groupTable = DB::table('admin_group');
        $shopTable = DB::table('admin_shop');
        if ($userInfo['userGroup'] == '1') {
            $groupInfo = $groupTable
                ->where('status', '0')
                ->lists('groupId', 'groupName');
            $shopInfo = $shopTable
                ->where('status', '0')
                ->lists('shopId', 'shopName');
        } else {
            $groupInfo = $groupTable
                ->where(
                    [
                        'groupId' => $userInfo['userGroup'],
                        'status' => '0',
                    ]
                )
                ->lists('groupId', 'groupName');
            $shopInfo = $shopTable
                ->where(
                    [
                        'shopId' => $userInfo['shopId'],
                        'status' => '0',
                    ]
                )
                ->lists('shopId', 'shopName');
        }
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('groupInfo' => $groupInfo, 'shopInfo' => $shopInfo));
    }

    /**
     * 执行添加用户
     * @param $data
     * @param $userInfo
     * @return array
     */
    public function setAddUser($data, $userInfo)
    {
        $passwordCode = str_random('6');
        $password = md5(md5($passwordCode) . md5($data['passWord']));
        if ($userInfo['userGroup'] == '1') {
            $group = $data['group'];
            $shop = $data['shop'];
        } else {
            $group = $userInfo['userGroup'];
            $shop = $userInfo['shopId'];
        }
        DB::table('admin_user')
            ->insert(
                [
                    'userName' => $data['userName'],
                    'realName' => $data['realName'],
                    'passCode' => $passwordCode,
                    'passWord' => $password,
                    'group' => $group,
                    'shop' => $shop,
                    'createTime' => time()
                ]
            );
        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**
     * 执行用户启用、弃用操作
     * @param int $userId
     * @param int $status
     * @param array $userInfo
     * @return array
     */
    public function enableUser($userId, $status, $userInfo)
    {
        if ($userInfo['userGroup'] != '1' && $userInfo['groupLeader'] !='1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $setUser = DB::table('admin_user')
                ->where('id', $userId)
                ->first();
        if (!$setUser) {
            return array('code' => '0', 'msg' => '用户不存在！', 'data' => '');
        }
        $setUser = objectToArray($setUser);
        //当操作用户非管理员的时候 判断是否为组长 及用户是否属于该组的组员
        if ($userInfo['userGroup'] != '1') {
            if ($setUser['group'] != $userInfo['userGroup'] || $setUser['groupleader']=='1') {
                return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
            }
        }
        DB::table('admin_user')
            ->where('id', $userId)
            ->update(
                [
                    'status' => $status,
                    'updateTime' => time()
                ]
            );
        return array('code' => '1', 'msg' => '操作成功！', 'data' => '');
    }

    /**
     * 锁定用户IP 获取用户信息
     * @param int $userId
     * @param array $userInfo
     * @return array
     */
    public function lockUserInfo($userId, $userInfo)
    {
        if ($userInfo['userGroup'] != '1' && $userInfo['groupLeader'] !='1' && $userInfo['userId'] != $userId) {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        $setUser = DB::table('admin_user')
            ->where('id', $userId)
            ->first();
        if (!$setUser) {
            return array('code' => '0', 'msg' => '用户不存在！', 'data' => '');
        }
        $setUser = objectToArray($setUser);
        if ($userInfo['userGroup'] != '1' && $setUser['group'] != $userInfo['userGroup']) {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $setUser['limitIp'] = empty($setUser['limitIp']) ? '' : explode(',', $setUser['limitIp']);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $setUser);
    }

    /**
     * 执行用户IP 锁定与解锁
     * @param int $userId
     * @param array $userInfo
     * @return array
     */
    public function lockUser($data, $userInfo)
    {
        $setInfo = $this->lockUserInfo($data['userId'], $userInfo);
        if ($setInfo['code'] != '1') {
            return $setInfo;
        }
        $userIpList = $setInfo['data']['limitIp'];
        $ipNum = count($userIpList);

        if ($data['type'] == '1') {
            if ($ipNum >= 10) {
                return array('code' => '0', 'msg' => 'IP限制已达上限！', 'data' => '');
            }
            if (in_array($data['ipAdd'], $userIpList)) {
                return array('code' => '0', 'msg' => 'IP地址已存在！', 'data' => '');
            }
            $userIpList[] = $data['ipAdd'];
        } elseif ($data['type'] == '2') {
            if (!in_array($data['ipAdd'], $userIpList)) {
                return array('code' => '0', 'msg' => 'IP地址不存在！', 'data' => '');
            }
            $key = array_search($data['ipAdd'], $userIpList);
            unset($userIpList["{$key}"]);
        }

        $limitIp = implode(',', $userIpList);
        DB::table('admin_user')
            ->where('id', $data['userId'])
            ->update(
                [
                    'limitIp' => $limitIp,
                    'updateTime' => time()
                ]
            );
        return array('code' => '1', 'msg' => '操作成功！', 'data' => '');
    }

    /**
     * 修改用户密码 管理员可以修改所有用户密码  组长可以修改小组成员密码
     * @param int $userId
     * @param array $userInfo
     * @return array
     */

    public function resetKey($userId, $userInfo)
    {
        if ($userInfo['userGroup'] != '1' && $userInfo['groupLeader'] !='1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        $setUser = DB::table('admin_user')
            ->where('id', $userId)
            ->first();
        if (!$setUser) {
            return array('code' => '0', 'msg' => '用户不存在！', 'data' => '');
        }
        $setUser = objectToArray($setUser);
        if ($userInfo['userGroup'] != '1' && $setUser['group'] != $userInfo['userGroup']) {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $setUser);
    }

    /**
     * 执行用户密码重置
     * @param int $userId
     * @param array $userInfo
     * @return array
     */

    public function resetUserKey($data, $userInfo)
    {
        $setInfo = $this->resetKey($data['userId'], $userInfo);
        if ($setInfo['code'] != '1') {
            return $setInfo;
        }

        $passwordCode = str_random('6');
        $newPassword = md5(md5($passwordCode) . md5($data['passWord']));
        DB::table('admin_user')
            ->where('id', $data['userId'])
            ->update(
                [
                    'errorNum' => '0',
                    'updateTime' => time(),
                    'passCode' => $passwordCode,
                    'passWord' => $newPassword
                ]
            );
        return array('code' => '1', 'msg' => '修改成功！', 'data' => '');
    }

    /**
     * 查询用户组
     * @param array $userInfo
     * @return array
     */

    public function adminGroup($userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        $groupList = DB::table('admin_group')
            ->paginate(10);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $groupList);
    }

    /**
     * 添加用户组
     * @param array $userInfo
     * @return array
     */

    public function addUserGroup($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        DB::table('admin_group')
            ->insert(
                [
                    'groupName' => $data['groupName'],
                    'createTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**
     * 查询用户组信息
     * @param int $groupId
     * @param array $userInfo
     * @return array
     */

    public function getGroupInfo($groupId, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $groupInfo = DB::table('admin_group')
            ->where('groupId', $groupId)
            ->first();
        if (!$groupInfo) {
            return array('code' => '0', 'msg' => '用户组不存在！', 'data' => '');
        }
        $groupInfo = objectToArray($groupInfo);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $groupInfo);
    }

    /**
     * 更新用户组信息
     * @param array $data
     * @param array $userInfo
     * @return array
     */

    public function updateGroup($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        DB::table('admin_group')
            ->where('groupId', $data['groupId'])
            ->update(
                [
                    'groupName' => $data['groupName'],
                    'status' => $data['status'],
                    'updateTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '更新成功！', 'data' => '');
    }

    /**
     * 查询商店
     * @param array $userInfo
     * @return array
     */

    public function adminShop($userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        $shopList = DB::table('admin_shop')
            ->paginate(10);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $shopList);
    }

    /**
     * 添加商店
     * @param array $userInfo
     * @return array
     */

    public function addShop($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        DB::table('admin_shop')
            ->insert(
                [
                    'shopName' => $data['shopName'],
                    'createTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**
     * 查询商店信息
     * @param int $shopId
     * @param array $userInfo
     * @return array
     */

    public function getShopInfo($shopId, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $shopInfo = DB::table('admin_shop')
            ->where('shopId', $shopId)
            ->first();
        if (!$shopInfo) {
            return array('code' => '0', 'msg' => '用户组不存在！', 'data' => '');
        }
        $shopInfo = objectToArray($shopInfo);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $shopInfo);
    }

    /**
     * 更新用户组信息
     * @param array $data
     * @param array $userInfo
     * @return array
     */

    public function updateShop($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        DB::table('admin_shop')
            ->where('shopId', $data['shopId'])
            ->update(
                [
                    'shopName' => $data['shopName'],
                    'status' => $data['status'],
                    'updateTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '更新成功！', 'data' => '');
    }

    /**
     * 获取目录名称和ID
     * @param array $userInfo
     * @return array
     */

    public function getMenu($userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        $menu = DB::table('admin_menu')
            ->where('parentId', '0')
            ->lists('name','id');

        return array('code' => '1', 'msg' => '查询成功！', 'data' => $menu);
    }

    /**
     * 添加项目
     * @param array $data
     * @param array $userInfo
     * @return array
     */

    public function addProject($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }
        DB::table('admin_menu')
            ->insert(
                [
                    'name' => $data['name'],
                    'url' => trim($data['url'], '/'),
                    'show' => $data['show'],
                    'parentId' => $data['parentId'],
                    'createTime' => time(),
                ]
            );

        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**
     * 获取目录名称和ID
     * @param array $userInfo
     * @return array
     */

    public function getLoginLog($userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            return array('code' => '0', 'msg' => '您没有权限！', 'data' => '');
        }

        $logList = DB::table('admin_login_log')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $logList);
    }
}
