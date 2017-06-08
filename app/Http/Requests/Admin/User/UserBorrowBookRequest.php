<?php

/**
 * @author dazhen
 * @example 用于后台用户借书验证
 */

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Request;

class UserBorrowBookRequest extends Request
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
            'bookId' => 'required|integer|min:1',
            'num' => 'required|integer|min:1',
            'userId' => 'required|integer|min:1',
        ];
    }
}
