<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\InvalidCastException;
use LogicException;

class RegisterController extends Controller
{
    /**
     * 注册
     * @param RegisterRequest $request
     * @param User $user
     * @return array
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     * @throws MassAssignmentException
     * @throws InvalidCastException
     * @throws Exception
     * @throws LogicException
     */
    public function register(RegisterRequest $request, User $user)
    {
        $fieldName = app('user')->accountFieldName($request->account);
        $data = ['password' => Hash::make($request->password), $fieldName => request('account')] + $request->input();

        $user->fill($data)->save();

        return $this->success('注册成功', ['token' => $user->createToken('auth')->plainTextToken]);
    }
}
