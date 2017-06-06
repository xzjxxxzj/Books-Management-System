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
     * @return array
     */

    public function getBookList($get)
    {
        $table = DB::table('book_list');
        if (!empty($get['type']) && in_array($get['type'], ['typeId', 'shopId']) && !empty($get['typeValue'])) {
            $table->where($get['type'], $get['typeValue']);
        } elseif (!empty($get['type']) && in_array($get['type'], ['bookName']) && !empty($get['name'])) {
            $table->where($get['type'], $get['name']);
        }
        $bookList =  $table->orderBy('bookId', 'desc')
                ->paginate(10);

        $bookType = DB::table('book_type')
                ->lists('typeName', 'typeId');

        $shopName = DB::table('admin_shop')
                ->lists('shopName', 'shopId');

        $getType = [
            'typeId' => '图书类别',
            'shopId' => '商店名称',
            'bookName' => '图书名字',
        ];
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('bookList' => $bookList, 'getType' => $getType, 'bookType' => $bookType, 'shopType' => $shopName));
    }

    /**
     * 添加图书
     * @param array $userInfo
     * @return array
     */

    public function getAddInfo($userInfo)
    {
        $bookType = DB::table('book_type')
            ->lists('typeName', 'typeId');

        if ($userInfo['userGroup'] != '1') {
            $shopName = DB::table('admin_shop')
                ->where('shopId', $userInfo['shopId'])
                ->lists('shopName', 'shopId');
        } else {
            $shopName = DB::table('admin_shop')
                ->lists('shopName', 'shopId');
        }
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('bookType' => $bookType, 'shopType' => $shopName));
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

    public function addBookType($data)
    {
        DB::table('book_type')
            ->insert(
                [
                    'typeName' => $data['typeName'],
                    'createTime' => time(),
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
            ->where('typeId', $typeId)
            ->first();
        if (!$typeInfo) {
            return array('code' => '0', 'msg' => '类别不存在！', 'data' => '');
        }
        $typeInfo = objectToArray($typeInfo);
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
            ->where('typeId', $data['typeId'])
            ->update(
                [
                    'typeName' => $data['typeName'],
                    'status' => $data['status'],
                    'updateTime' => time(),
                ]
            );
        return array('code' => '1', 'msg' => '更新成功！', 'data' => '');
    }

    /**
     * 更新类别信息
     * @param array $files
     * @return array
     */

    public function addBookImage($files)
    {
        $insertId= '';
        foreach ($files as $value) {
            $id = DB::table('file')
                ->insertGetId(
                    [
                        'fileName' => $value['name'],
                        'path' => $value['path'],
                        'createTime' =>time(),
                    ]
                );
            $insertId .= $id . ',';
        }
        return array('code' => '1', 'msg' => '添加成功！', 'data' => trim($insertId, ','));
    }

    /**
     * 更新类别信息
     * @param array $data
     * @return array
     */

    public function addBook($data, $userInfo)
    {
        if ($userInfo['userGroup'] != '1') {
            $shopId = $userInfo['shopId'];
        } else {
            $shopId = $data['shopId'];
        }

        $data['bookName'] = htmlspecialchars($data['bookName']);
        $data['profile'] = htmlspecialchars($data['profile']);
        DB::table('book_list')
            ->insert(
                [
                    'bookName' => $data['bookName'],
                    'shopId' => $shopId,
                    'money' => $data['money'],
                    'num' => $data['leftNum'],
                    'leftNum' => $data['leftNum'],
                    'typeId' => $data['typeId'],
                    'image' => $data['imagePath'],
                    'minAge' => $data['minAge'],
                    'maxAge' => $data['maxAge'],
                    'profile' => $data['profile'],
                    'createTime' => time(),
                ]
            );
        if (!empty($data['fileId'])) {
            $fileId = explode(',', $data['fileId']);

            DB::table('file')
                ->whereIn('fileid', $fileId)
                ->update(
                    [
                        'status' => '1',
                        'useMsg' => $data['bookName'] . '图书封面',
                        'updateTime' => time(),
                    ]
                );
        }
        return array('code' => '1', 'msg' => '添加成功！', 'data' => '');
    }

    /**获取图书信息，修改图书用
     * @param int $bookId
     * @param array $userInfo
     * @return array
     */

    public function getBookInfo($bookId, $userInfo)
    {
        $bookType = DB::table('book_type')
            ->lists('typeName', 'typeId');

        if ($userInfo['userGroup'] != '1') {
            $shopName = DB::table('admin_shop')
                ->where('shopId', $userInfo['shopId'])
                ->lists('shopName', 'shopId');
        } else {
            $shopName = DB::table('admin_shop')
                ->lists('shopName', 'shopId');
        }

        $bookInfo = DB::table('book_list')
            ->where('bookId', $bookId)
            ->first();

        $bookInfo = objectToArray($bookInfo);

        $bookOrder = DB::table('book_order')
            ->join('user', 'book_order.userId', '=', 'user.userId')
            ->where('book_order.bookId', $bookId)
            ->limit(3)
            ->select('book_order.*', 'user.userName')
            ->get();
        $bookOrder = objectToArray($bookOrder);
        return array('code' => '1', 'msg' => '查询成功！', 'data' => array('bookType' => $bookType, 'shopType' => $shopName, 'bookInfo' => $bookInfo, 'bookOrder'=>$bookOrder));
    }

    /**获取图书信息，修改图书用
     * @param array $data
     * @param array $userInfo
     * @return array
     */

    public function updateBook($data, $userInfo)
    {
        //获取原图片，方便删除
        $file = DB::table('book_list')
            ->where('bookId', $data['bookId'])
            ->value('image');

        if ($userInfo['userGroup'] != '1') {
            $shopId = $userInfo['shopId'];
        } else {
            $shopId = $data['shopId'];
        }
        $data['bookName'] = htmlspecialchars($data['bookName']);
        $data['profile'] = htmlspecialchars($data['profile']);
        if ($data['leftNum'] >= 0) {
            $data['leftNum'] = ' + ' .$data['leftNum'];
        }
        DB::table('book_list')
            ->where('bookId', $data['bookId'])
            ->update(
                [
                    'bookName' => $data['bookName'],
                    'shopId' => $shopId,
                    'money' => $data['money'],
                    'num' => DB::raw('num ' . $data['leftNum']),
                    'leftNum' => DB::raw('leftNum ' . $data['leftNum']),
                    'typeId' => $data['typeId'],
                    'image' => $data['imagePath'],
                    'minAge' => $data['minAge'],
                    'maxAge' => $data['maxAge'],
                    'profile' => $data['profile'],
                    'updateTime' => time(),
                ]
            );
        //如果图片有修改
        if ($file != $data['imagePath']) {
            echo $filePath = public_path($file);
            //删除图片
            if (file_exists($filePath))
            {
                echo $filePath;
                unlink($filePath);
            }
            DB::table('file')
                ->where('path', $file)
                ->delete();

            if (!empty($data['fileId'])) {
                $fileId = explode(',', $data['fileId']);

                DB::table('file')
                    ->whereIn('fileid', $fileId)
                    ->update(
                        [
                            'status' => '1',
                            'useMsg' => $data['bookName'] . '图书封面',
                            'updateTime' => time(),
                        ]
                    );
            }
        }
        return array('code' => '1', 'msg' => '修改成功！', 'data' => '');
    }
}
