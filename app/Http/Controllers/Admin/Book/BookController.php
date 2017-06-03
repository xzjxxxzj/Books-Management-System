<?php

/**
 * @author dazhen
 * @example 用于管理员登陆
 */

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Controller;
use App\Model;
use App\Http\Requests;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $userInfo;
    private $permission;

    public function __construct(Request $request)
    {
        $user = Model\Admin\AdminSession::getAdminInfo('AdminInfo');
        if (!$user)
        {
            header ( "Location: " . url('admin/login'));
            die();
        }
        $this->userInfo = $user;
        $this->permission = new Model\Admin\AdminPermission();
        if (!$this->permission->isPermission($request->path())) {
           echo jumppage(false, array('打开失败' => '您没有权限！'), array('返回' => url('admin')));
           exit;
        }
    }

    /**
     * 图书列表
     */

    public function bookList(Requests\Admin\Book\BookGetListRequest $request)
    {
        $bookLogic = new Model\Admin\Book\BookLogic();
        $bookList = $bookLogic->getBookList($request->all());
        return view('admin.book.bookList', $bookList['data']);
    }

    /**
     * 添加图书
     */

    public function addBook()
    {
        return view('admin.book.addBook');
    }

    /**
     * 图书类别列表
     */
    public function bookType()
    {
        $bookLogic = new Model\Admin\Book\BookLogic();
        $bookType = $bookLogic->getBooType();
        $data['bookType'] = $bookType['data'];
        return view('admin.book.bookType', $data);
    }

    /**
     * 添加图书类别
     */

    public function addBookType()
    {
        return view('admin.book.addBookType');
    }

    /**
     * 添加图书类别信息提交控制器
     */

    public function setAddBookType(Requests\Admin\Book\BookSetAddBookTypeRequest $request)
    {
        $bookLogic = new Model\Admin\Book\BookLogic();
        $addBookType = $bookLogic->addUserGroup($request->all());
        if ($addBookType['code'] != '1') {
            return jumpPage(false, array('添加失败' => $addBookType['msg']), array('返回' => url('admin/book/bookType')));
        }
        return jumpPage(true, array('添加成功' => '添加成功！'), array('返回' => url('admin/book/bookType')));
    }

    /**
     * 设置图书类别
     */

    public function setBookType($typeId)
    {
        $bookLogic = new Model\Admin\Book\BookLogic();
        $typeInfo = $bookLogic->getTypeInfo($typeId);
        if ($typeInfo['code'] != '1') {
            return jumpPage(false, array('打开失败' => $typeInfo['msg']), array('返回' => url('admin/book/bookType')));
        }
        $data['typeInfo'] = $typeInfo['data'];
        return view('admin.book.setBookType', $data);
    }

    /**
     * 修改图书类别信息提交控制器
     */

    public function updateBookType(Requests\Admin\Book\BookUpdateBookTypeRequest $request)
    {
        $bookLogic = new Model\Admin\Book\BookLogic();
        $updateBookType = $bookLogic->updateBookType($request->all());
        if ($updateBookType['code'] != '1') {
            return jumpPage(false, array('修改失败' => $updateBookType['msg']), array('返回' => url('admin/book/bookType')));
        }
        return jumpPage(true, array('修改成功' => '修改成功！'), array('返回' => url('admin/book/bookType')));
    }
}
