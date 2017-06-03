<?php

/**
 * @author dazhen
 * @example 用于后台新增图书类别验证
 */

namespace App\Http\Requests\Admin\Book;

use App\Http\Requests\Request;

class BookSetAddBookTypeRequest extends Request
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
            'typeName' => 'required|unique:book_type,typename|regex:/^[0-9a-zA-Z_\-\x{4e00}-\x{9fa5}]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'typeName.required' => '类别名称不能为空！',
            'typeName.regex' => '类别名称格式不正确！',
            'typeName.unique' => '类别名称已存在！',
        ];
    }
}
