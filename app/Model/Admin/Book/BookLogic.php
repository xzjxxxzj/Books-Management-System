<?php

/**
 * @author dazhen
 * @example 用于图书逻辑编写
 */

namespace App\Model\Admin\Book;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Admin\AdminSession;

class BookLogic extends Model
{

    /**
     * 获取图书列表
     * @param array $get
     * @return true
     */

    public function getBookList($get)
    {
        $table = DB::table('book_list');
        if (!empty($get['type']) && in_array($get['type'], ['typeid', 'shopid']) && !empty($get['typeValue'])) {
            $table->where($get['type'], $get['typeValue']);
        } elseif (!empty($get['type']) && in_array($get['type'], ['bookname']) && !empty($get['name'])) {
            $table->where($get['type'], $get['name']);
        }
        $bookList =  $table->orderBy('bookid', 'desc')
                ->paginate(10);

        $bookType = DB::table('book_type')
                ->lists('typename', 'typeid');

        $shopName = DB::table('admin_shop')
                ->lists('shopname', 'shopid');

        $getType = [
            'typeid' => '图书类别',
            'shopid' => '商店名称',
            'bookname' => '图书名字',
        ];

        foreach ($bookList as $key => $value) {
            $bookList->$key->typename = $bookType["{$value->typeid}"];
            $bookList->$key->shopname = $shopName["{$value->shopid}"];
        }

        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('bookList' => $bookList, 'getType' => $getType, 'bookType' => $bookType, 'shopType' => $shopName));
    }

    /**
     * 获取图书类别列表
     * @return true
     */

    public function getBooType()
    {
        $list = DB::table('book_type')
                ->paginate(10);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $list);
    }

    /**
     * 添加图书类别
     * @param array $data
     * @return array
     */

    public function addUserGroup($data)
    {
        DB::table('book_type')
            ->insert(
                [
                    'typename' => $data['typeName'],
                    'createtime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**
     * 查询图书类别信息
     * @param int $typeId
     * @return array
     */

    public function getTypeInfo($typeId)
    {
        $typeInfo = DB::table('book_type')
            ->where('typeid', $typeId)
            ->first();
        if (!$typeInfo) {
            return array('code' => '0', 'msg' => '类别不存在！', 'data' => '');
        }
        $typeInfo = get_object_vars($typeInfo);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => $typeInfo);
    }

    /**
     * 更新类别信息
     * @param array $data
     * @return array
     */

    public function updateBookType($data)
    {
        DB::table('book_type')
            ->where('typeid', $data['typeId'])
            ->update(
                [
                    'typename' => $data['typeName'],
                    'status' => $data['status'],
                    'updatetime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '更新成功！', 'data' => '');
    }
}
