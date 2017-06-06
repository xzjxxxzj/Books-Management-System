<?php

/**
 * @author dazhen
 * @example 用于管理员登陆模型编写
 */

namespace App\Model\Admin\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Admin\AdminSession;

class AdminLogin extends Model
{

    /**
     * 管理员登陆
     * @param array $data
     * @return array
     */

    public function userLogin($data)
    {
        $user = DB::table('admin_user')
            ->where('userName', $data['userName'])
            ->first();
        if (!$user) {
            return array('code' => '0', 'msg' => '用户不存在！');
        }
        $user = objectToArray($user);
        $ip = getIp();
        if (!empty($user['limitIp'])) {
            $limitIp = explode(',', $user['limitIp']);
            if (!in_array($ip, $limitIp)) {
                return array('code' => '0', 'msg' => 'Ip地址不正确！');
            }
        }
        if ($user['errorNum'] >= config('config.adminPassError') || $user['status'] == '1') {
            return array('code' => '0', 'msg' => '账号被限制登陆！');
        }
        $passWord = md5(md5($user['passCode']) . md5($data['passWord']));
        if ($passWord != $user['passWord']) {
            $this->addDataLog($user);
            return array('code' => '0', 'msg' => '密码错误！');
        }
        $this->updateSession('', $user);
        $this->addDataLog($user, 1);
        return array('code' => '1', 'msg' => '登陆成功！', 'data' => $user);
    }

    /**
     *  session 写入
     * @param int $userId
     * @return bool
     */

    private function updateSession($userId='', $userInfo = '')
    {
        if (!$userId && !$userInfo) {
            return false;
        }
        if (!$userInfo) {
            $userInfo = DB::table('admin_user')
                ->where('id', $userId)
                ->first();
            $userInfo = objectToArray($userInfo);
        }
        $sessionData = [
            'userId' => $userInfo['id'],
            'userGroup' => $userInfo['group'],
            'groupLeader' => $userInfo['groupLeader'],
            'shopId' => $userInfo['shop'],
            'userName' => $userInfo['userName'],
            'lastLoginIp' => $userInfo['lastLoginIp'],
            'lastLoginTime' => $userInfo['lastLoginTime']
        ];
       AdminSession::setAdminInfo('AdminInfo', $sessionData);
       return true;
    }

    /**
     *  登录日志写入
     * @param array $user
     * @param bool $status 登陆状态 0登陆失败 ， 1登陆成功
     * @return bool
     */

    private function addDataLog($user, $status = 0)
    {
        $status = $status == 1 ? $status : 0;
        DB::table('admin_login_log')
            ->insert(
            [
                'userId' => $user['id'],
                'userName' => $user['userName'],
                'loginIp' => getIp(),
                'time' => time(),
                'status' => $status
            ]
        );
        if ($status == 1) {
            DB::table('admin_user')
                ->where('id', $user['id'])
                ->update(
                    [
                        'errorNum' => '0',
                        'updateTime' => time(),
                        'lastLoginIp' => getIp(),
                        'lastLoginTime' => time()
                    ]
                );
        } else {
            DB::table('admin_user')
                ->where('id', $user['id'])
                ->increment(
                    'errorNum',
                    '1',
                    [
                        'updateTime' => time()
                    ]
                );
        }
        return true;
    }
}
