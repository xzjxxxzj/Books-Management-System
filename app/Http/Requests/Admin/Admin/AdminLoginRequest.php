<?php

/**
 * @author dazhen
 * @example 用于后台登陆验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminLoginRequest extends Request
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
            'userName' => 'required|alpha_dash|min:5|max:16|exists:admin_user,userName',
            'passWord' => 'required|min:6',
        ];
    }
    
    public function messages()
    {
        return [
            'userName.required' => '用户名不能为空！',
            'userName.alpha_dash'  => '用户名不能包含特殊字符！',
            'userName.min' => '用户名不能小于5个字符！',
            'userName.max'  => '用户名不能大于16字符！',
            'userName.exists'  => '用户名不存在！',

            'passWord.required' => '密码不能为空！',
            'passWord.min' => '密码不能小于6个字符！',
        ];
    }
}
