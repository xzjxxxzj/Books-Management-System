<?php

/**
 * @author dazhen
 * @example 用于后台借书列表验证
 */

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Request;

class UserBorrowListRequest extends Request
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
        ];
    }
}
