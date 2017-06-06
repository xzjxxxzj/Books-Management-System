<?php

/**
 * @author dazhen
 * @example 用于后台新增管理员验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminSetAddUserRequest extends Request
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
            'userName' => 'required|min:6|max:16|alpha_num|unique:admin_user,userName',
            'realName' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
            'password' => 'required|min:6|max:20',
            'group' => 'required|integer|exists:admin_group,groupId,status,1',
            'shop' => 'required|integer|exists:admin_shop,shopId,status,1',
            'groupLeader' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'userName.required' => '用户名不能为空！',
            'userName.min' => '用户名不能小于5个字符！',
            'userName.max'  => '用户名不能大于16字符！',
            'userName.alpha_num'  => '用户名只能由字母和数字组成！',
            'userName.unique'  => '用户名用户名已存在！',

            'realName.required' => '姓名不能为空！',
            'realName.regex' => '姓名格式不正确！',

            'password.required' => '密码不能为空！',
            'password.min' => '密码不能小于5个字符！',
            'password.max'  => '密码不能大于16字符！',

            'group.integer'  => '用户组只能为整数！',
            'group.required' => '用户组不能为空！',
            'group.exists' => '用户组不存在！',

            'shop.integer'  => '商店只能为整数！',
            'shop.required' => '商店不能为空！',
            'shop.exists' => '商店不存在！',

            'groupLeader.integer'  => '组长只能为整数！',
        ];
    }
}
