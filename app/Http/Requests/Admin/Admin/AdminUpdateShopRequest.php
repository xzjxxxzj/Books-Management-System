<?php

/**
 * @author dazhen
 * @example 用于后台更新商店信息验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminUpdateShopRequest extends Request
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
            'status' => 'required|boolean',
            'shopId' => 'required|integer|exists:admin_shop,shopid',
        ];
    }

    public function messages()
    {
        return [
            'shopName.required' => '商店名称不能为空！',
            'shopName.regex' => '商店名称格式不正确！',
            'shopName.unique' => '商店名称已存在！',


            'status.required' => '状态不能为空！',
            'status.boolean' => '状态参数错误！',

            'shopId.required' => '商店不能为空！',
            'shopId.integer' => '商店参数错误！',
            'shopId.exists' => '商店ID不存在！',
        ];
    }
}
