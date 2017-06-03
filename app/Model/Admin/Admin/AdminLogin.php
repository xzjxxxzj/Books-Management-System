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
            ->where('username', $data['UserName'])
            ->first();
        if (!$user) {
            return array('code' => '0', 'msg' => '用户不存在！');
        }
        $user = get_object_vars($user);
        $ip = getIp();
        if (!empty($user['limitip'])) {
            $limitIp = explode(',', $user['limitip']);
            if (!in_array($ip, $limitIp)) {
                return array('code' => '0', 'msg' => 'Ip地址不正确！');
            }
        }
        if ($user['errornum'] >= config('config.adminPassError') || $user['status'] == '1') {
            return array('code' => '0', 'msg' => '账号被限制登陆！');
        }
        $passWord = md5(md5($user['passcode']) . md5($data['PassWord']));
        if ($passWord != $user['password']) {
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
            $userInfo = get_object_vars($userInfo);
        }
        $sessionData = [
            'userId' => $userInfo['id'],
            'userGroup' => $userInfo['group'],
            'groupLeader' => $userInfo['groupleader'],
            'shopId' => $userInfo['shop'],
            'userName' => $userInfo['username'],
            'lastLoginIp' => $userInfo['lastloginip'],
            'lastLoginTime' => $userInfo['lastlogintime']
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
                'userid' => $user['id'],
                'username' => $user['username'],
                'loginip' => getIp(),
                'time' => time(),
                'status' => $status
            ]
        );
        if ($status == 1) {
            DB::table('admin_user')
                ->where('id', $user['id'])
                ->update(
                    [
                        'errornum' => '0',
                        'updatetime' => time(),
                        'lastloginip' => getIp(),
                        'lastlogintime' => time()
                    ]
                );
        } else {
            DB::table('admin_user')
                ->where('id', $user['id'])
                ->increment(
                    'errornum',
                    '1',
                    [
                        'updatetime' => time()
                    ]
                );
        }
        return true;
    }
}