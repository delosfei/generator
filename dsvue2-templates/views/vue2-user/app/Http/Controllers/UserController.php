<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\InvalidCastException;
use InvalidArgumentException;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    public function info()
    {
        return new UserResource(Auth::user());
    }


    /**
     * 更新用户资料
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     * @throws MassAssignmentException
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function update(Request $request)
    {
        $this->authorize('update', Auth::user());

        Auth::user()->fill($request->input())->save();
        return $this->success('资料修改成功', Auth::user());
    }

    /**
     * 获取用户角色　　
     * @param User $user
     * @return Collection
     * @throws BindingResolutionException
     */
    public function roles(User $user)
    {
        return $user->roles()->pluck('name');
    }

    /**
     * 同步用户角色
     * @param Request $request
     * @param User $user
     * @return void
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function syncRoles(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return $this->success('用户角色设置成功');
    }
}
