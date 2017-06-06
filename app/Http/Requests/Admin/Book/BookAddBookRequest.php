<?php

/**
 * @author dazhen
 * @example 用于后台新增图书验证
 */

namespace App\Http\Requests\Admin\Book;

use App\Http\Requests\Request;

class BookAddBookRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bookName' => 'required',
            'leftNum' => 'required|integer|min:0',
            'money' => 'required|numeric|min:0',
            'shopId' => 'required|integer|min:1|exists:admin_shop,shopId',
            'typeId' => 'required|integer|min:1|exists:book_type,typeId',
            'minAge' => 'integer|min:0',
            'maxAge' => 'integer|min:0',
            'fileId' => 'regex:/^[0-9,]+$/u|exists:file,fileId',
            'imagePath' => 'regex:/^[0-9a-zA-Z.\/]+$/u',
            'profile' => '',
        ];
    }

    public function messages()
    {
        return [
            'bookName.required' => '图书名称不能为空！',

            'leftNum.required' => '库存不能为空！',
            'leftNum.integer' => '库存格式不正确！',
            'leftNum.min' => '库存不能小于0！',

            'money.required' => '价格不能为空！',
            'money.numeric' => '价格格式不正确！',
            'money.min' => '价格不能小于0！',

            'shopId.required' => '商店不能为空！',
            'shopId.integer' => '商店格式不正确！',
            'shopId.min' => '商店不能小于1！',
            'shopId.exists' => '商店不存在！',

            'typeId.required' => '类型不能为空！',
            'typeId.integer' => '类型格式不正确！',
            'typeId.min' => '类型不能小于1！',
            'typeId.exists' => '类型不存在！',

            'minAge.integer' => '最小年龄格式不正确！',
            'minAge.min' => '最小年龄不能小于0！',

            'maxAge.integer' => '最大年龄格式不正确！',
            'maxAge.min' => '最大年龄不能小于0！',

            'fileId.regex' => '图片ID格式不正确！',
            'fileId.exists' => '封面图片不存在！',

            'imagePath.regex' => '图片地址格式不正确！',
        ];
    }
}
