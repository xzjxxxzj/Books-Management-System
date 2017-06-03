<?php

/**
 * @author dazhen
 * @example 用于后台更新用户组信息验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminUpdateGroupRequest extends Request
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
            'groupName' => 'required|unique:admin_group,groupname|regex:/^[0-9a-zA-Z_\-\x{4e00}-\x{9fa5}]+$/u',
            'status' => 'required|boolean',
            'groupId' => 'required|integer|exists:admin_group,groupid',
        ];
    }

    public function messages()
    {
        return [
            'groupName.required' => '用户组名称不能为空！',
            'groupName.regex' => '用户组名称格式不正确！',
            'groupName.unique' => '用户组名称已存在！',

            'status.required' => '状态不能为空！',
            'status.boolean' => '状态参数错误！',

            'groupId.required' => '用户组不能为空！',
            'groupId.integer' => '用户组参数错误！',
            'groupId.exists' => '用户组ID不存在！',
        ];
    }
}
