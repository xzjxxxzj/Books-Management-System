<?php

/**
 * @author dazhen
 * @example 用于后台获取用户列表查询验证
 */

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Request;

class UserGetListRequest extends Request
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
            'type' => 'alpha',
            'name' => 'regex:/^[0-9a-zA-Z_\-\x{4e00}-\x{9fa5}]+$/u',
        ];
    }
}
