<?php

/**
 * @author dazhen
 * @example 用于用户逻辑编写
 */

namespace App\Model\Admin\User;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserLogic extends Model
{
    /**
     * 获取用户列表
     * @param array $get
     * @return array
     */

    public function getUserList($get)
    {
        $table = DB::table('user');
        if (!empty($get['type']) && in_array($get['type'], ['userName', 'realName', 'mobile']) && !empty($get['name'])) {
            $table->where($get['type'], $get['name']);
        }
        $userList =  $table->orderBy('userId', 'desc')
            ->paginate(10);

        $getType = [
            'userName' => '用户名',
            'realName' => '用户姓名',
            'mobile' => '用户手机',
        ];
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('userList' => $userList, 'getType' => $getType));
    }
}
