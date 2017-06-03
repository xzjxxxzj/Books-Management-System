<?php

/**
 * @author dazhen
 * @example 用于后台新增用户组验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminSetAddGroupRequest extends Request
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
        ];
    }

    public function messages()
    {
        return [
            'groupName.required' => '用户组名称不能为空！',
            'groupName.regex' => '用户组名称格式不正确！',
            'groupName.unique' => '用户组名称已存在！',
        ];
    }
}
