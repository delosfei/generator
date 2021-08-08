<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 用户验证
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'account' => ['required']
        ];
    }

    public function attributes()
    {
        return ['account' => '帐号'];
    }
}
