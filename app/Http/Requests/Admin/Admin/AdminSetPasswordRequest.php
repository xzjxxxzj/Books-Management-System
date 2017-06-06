<?php

/**
 * @author dazhen
 * @example 用于后台修改管理员密码验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminSetPasswordRequest extends Request
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
            'oldPassword' => 'required|min:6|max:20',
            'passWord' => 'required|min:6|max:20|different:oldPassword',
            'rePassword' => 'required|same:passWord',
        ];
    }

    public function messages()
    {
        return [
            'oldPassword.required' => '旧密码不能为空！',
            'oldPassword.min' => '旧密码不能小于5个字符！',
            'oldPassword.max'  => '旧密码不能大于16字符！',

            'passWord.different'  => '新密码不能跟旧密码设置一样！',
            'passWord.required' => '新密码不能为空！',
            'passWord.min' => '新密码不能小于5个字符！',
            'passWord.max'  => '新密码不能大于16字符！',

            'rePassword.same'  => '两次密码不一致！',
            'rePassword.required' => '重复密码不能为空！',
        ];
    }
}
