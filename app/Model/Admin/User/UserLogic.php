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

    /**
     * 获取用户列表
     * @param array $data
     * @return array
     */

    public function borrowBook($data)
    {
        $user = DB::table('user')
            ->where('userId', $data['userId'])
            ->first();
        if (!$user) {
            return array('code' => '0', 'msg' => '用户不存在！', 'data' => '');
        }

        $book = DB::table('book_list')
            ->where('bookId', $data['bookId'])
            ->first();
        if (!$book) {
            return array('code' => '0', 'msg' => '图书不存在！', 'data' => '');
        }
        $book = objectToArray($book);

        if ($book['leftNum'] < $data['num']) {
            return array('code' => '0', 'msg' => '图书库存不足！', 'data' => '');
        }
        //加订单
        DB::table('book_order')
            ->insert(
                [
                    'bookId' => $data['bookId'],
                    'userId' => $data['userId'],
                    'num' => $data['num'],
                    'status' => '1',
                    'borrowTime' => time(),
                    'createTime' => time(),
                ]
            );
        //减库存
        DB::table('book_list')
            ->where('bookId', $data['bookId'])
            ->update(
                [
                    'outNum' => DB::raw('outNum +' . $data['num']),
                    'leftNum' => DB::raw('leftNum -' . $data['num']),
                    'updateTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '借书成功！', 'data' => '');
    }

    /**
     * 获取用户借书列表
     * @param array $get
     * @return array
     */

    public function borrowList($get)
    {
        $getType = [
            'userName' => '用户名',
            'bookName' => '图书名',
        ];
        //查询
        $tables = DB::table('book_order')
            ->join('user', 'book_order.userId', '=', 'user.userId')
            ->join('book_list', 'book_order.bookId', '=', 'book_list.bookId');
        if (!empty($get['type']) && !empty($get['name'])) {
            if ($get['type'] == 'userName') {
                $tables->where('user.userName', $get['name']);
            } elseif($get['type'] == 'bookName') {
                $tables->where('book_list.bookName', $get['name']);
            }
        }
        $borrowList = $tables->orderBy('book_order.status', 'asc')
            ->select('book_order.*', 'user.userName', 'book_list.bookName')
            ->paginate('10');
        //图书状态
        $status = [
            '0' => '预定',
            '1' => '借阅中',
            '2' => '已归还',
            '3' => '丢失',
            '4' => '损坏',
            '5' => '订单失效',
        ];
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('getType' => $getType, 'borrowList' => $borrowList, 'status' => $status));
    }
}
