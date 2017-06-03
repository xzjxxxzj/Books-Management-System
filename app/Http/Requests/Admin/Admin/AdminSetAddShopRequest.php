<?php

/**
 * @author dazhen
 * @example 用于后台新增商店验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminSetAddShopRequest extends Request
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
            'shopName' => 'required|unique:admin_shop,shopname|regex:/^[0-9a-zA-Z_\-\x{4e00}-\x{9fa5}]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'shopName.required' => '商店名称不能为空！',
            'shopName.regex' => '商店名称格式不正确！',
            'shopName.unique' => '商店名称已存在！',
        ];
    }
}
