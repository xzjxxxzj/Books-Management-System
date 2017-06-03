<?php

/**
 * @author dazhen
 * @example 用于后台锁定管理员登录IP验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminLockUserRequest extends Request
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
            'type' => 'required|integer',
            'ipAdd' => 'required|ip',
            'userId' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '类型不能为空！',
            'type.integer' => '类型只能为整数！',

            'ipAdd.ip'  => 'IP地址格式错误！',
            'ipAdd.required' => 'IP地址不能为空！',

            'userId.integer'  => '用户ID只能为整数！',
            'userId.required' => '用户ID不能为空！',
        ];
    }
}
