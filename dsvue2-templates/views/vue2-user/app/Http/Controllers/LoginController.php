<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use UserService;
use Hash;

/**
 * 登录注册
 * @package App\Http\Controllers
 */

class LoginController extends Controller
{

    /**
     * 登录
     *
     * @param Request $request
     * @return void
     */
    public function login(LoginRequest $loginRequest)
    {
        $account = $loginRequest->account;

        $filedName = UserService::accountFieldName($account);

        $user = User::where($filedName, $loginRequest->account)->first();

        if (!$user || !Hash::check($loginRequest->password, $user->password)) {
            throw ValidationException::withMessages([
                'account' => ['帐号或密码错误'],
            ]);
        }

        return $this->success('登录成功', ['token' => $user->createToken('auth')->plainTextToken]);
    }
}
