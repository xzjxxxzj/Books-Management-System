<?php

namespace App\Http\Requests\Admin;

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
            'UserName' => 'required|alpha_dash|min:5|max:16|isin:admin_user,username',
            'PassWord' => 'required|min:6',
        ];
    }
    
    public function messages()
    {
        return [
            'UserName.required' => '用户名不能为空！',
            'UserName.alpha_dash'  => '用户名不能包含特殊字符！',
            'UserName.min' => '用户名不能小于5个字符！',
            'UserName.max'  => '用户名不能大于16字符！',
            'UserName.isin'  => '用户名不存在！',
            'PassWord.required' => '密码不能为空！',
            'PassWord.min' => '密码不能小于6个字符！',
        ];
    }
}
