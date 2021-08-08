<?php

namespace App\Services\User;



use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * 登录字段
     * @param mixed $account 帐号数据
     * @return string
     */
    public function accountFieldName($account)
    {
        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        if (preg_match('/^\d{11}$/', $account)) {
            return 'mobile';
        }

        throw ValidationException::withMessages([
            'account' => ['帐号格式错误']
        ]);
    }
}
