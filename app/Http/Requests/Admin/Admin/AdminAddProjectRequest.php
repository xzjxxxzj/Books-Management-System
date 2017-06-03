<?php

/**
 * @author dazhen
 * @example 用于后台新增项目验证
 */

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;

class AdminAddProjectRequest extends Request
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
            'name' => 'required|regex:/^[0-9a-zA-Z_\-\x{4e00}-\x{9fa5}]+$/u',
            'url' => 'required|unique:admin_menu,url|regex:/^[0-9a-zA-Z_\-\/]+$/u',
            'show' => 'required|boolean',
            'parentId' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '项目名称不能为空！',
            'name.regex' => '项目名称格式不正确！',

            'url.required' => '项目地址名称不能为空！',
            'url.regex' => '项目地址格式不正确！',
            'url.unique' => '项目地址已存在！',

            'show.required' => '显示状态不能为空！',
            'show.boolean' => '显示状态参数错误！',

            'parentId.required' => '父级不能为空！',
            'parentId.integer' => '父级格式不正确！',
        ];
    }
}
