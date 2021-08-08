<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        //手机，邮箱
        return [
            'account' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^.*@.*|\d{11}$/', $value)) {
                    $fail('帐号格式错误');
                }
            }],
            'password' => ['required', 'between:5,20'],
            'captcha' => ['sometimes', 'required', 'captcha_api:' . request('captcha_key') . ',default'],
        ];
    }

    public function messages()
    {
        return [
            'captcha.captcha_api' => '图形验证码输入错误'
        ];
    }

    public function attributes()
    {
        return [
            'account' => '帐号', 'password' => '密码', 'captcha' => '图形验证码'
        ];
    }
}
