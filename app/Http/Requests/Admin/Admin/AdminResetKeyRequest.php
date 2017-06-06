<?php

/**
 * @author dazhen
 * @example 用于后台修改管理员密码验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminResetKeyRequest extends Request
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
            'userId' => 'required|integer|exists:admin_user,userId',
            'passWord' => 'required|min:6|max:20',
            'rePassword' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'userId.required' => '用户ID不能为空！',
            'userId.integer' => '用户ID只能为整数！',
            'userId.exists' => '用户ID不存在！',

            'passWord.required' => '新密码不能为空！',
            'passWord.min' => '新密码不能小于5个字符！',
            'passWord.max'  => '新密码不能大于16字符！',

            'rePassword.same'  => '两次密码不一致！',
            'rePassword.required' => '重复密码不能为空！',
        ];
    }
}
