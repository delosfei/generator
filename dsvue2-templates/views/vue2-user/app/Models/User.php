<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'mobile',
        'name',
        'email',
        'real_name',
        'password',
        'home',
        'avatar',
        'wechat',
        'group_id',
        'email_verified_at',
        'mobile_verified_at',
        'favour_count',
        'favorite_count',
        'remember_token',
        'lock',
        'ren',
        'yi',
        'li',
        'zhi',
        'xin',
        'score',
        'is_super_admin',
        'current_team_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mobile' => 'string',
        'name' => 'string',
        'email' => 'string',
        'real_name' => 'string',
        'password' => 'string',
        'home' => 'string',
        'avatar' => 'string',
        'wechat' => 'string',
        'group_id' => 'integer',
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'favour_count' => 'integer',
        'favorite_count' => 'integer',
        'remember_token' => 'string',
        'lock' => 'boolean',
        'ren' => 'integer',
        'yi' => 'integer',
        'li' => 'integer',
        'zhi' => 'integer',
        'xin' => 'integer',
        'score' => 'integer',
        'is_super_admin' => 'boolean',
        'current_team_id' => 'integer',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'mobile',
    ];

    protected $appends = [
        'icon',
    ];

    /**
     * 超级管理员
     * @return void
     */
    public function getIsSuperAdminAttribute()
    {
        return $this->id == 1;
    }

    /**
     * 用户头像
     *
     * @return void
     */
    public function getIconAttribute()
    {
        return $this['avatar'] ?? url('/images/user.jpeg');
    }

    /**
     * 用户创建的所有站点
     *
     * @return void
     */
//    public function sites()
//    {
//
//    }
//
//    public function group()
//    {
//
//    }


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mobile' => 'nullable|string|max:15',
        'name' => 'nullable|string|max:30',
        'email' => 'nullable|string|max:50',
        'real_name' => 'nullable|string|max:20',
        'password' => 'nullable|string|max:255',
        'home' => 'nullable|string|max:255',
        'avatar' => 'nullable|string|max:255',
        'wechat' => 'nullable|string|max:255',
        'group_id' => 'required',
        'email_verified_at' => 'nullable',
        'mobile_verified_at' => 'nullable',
        'favour_count' => 'required|integer',
        'favorite_count' => 'required|integer',
        'remember_token' => 'required|string|max:100',
        'lock' => 'nullable|boolean',
        'ren' => 'required|integer',
        'yi' => 'required|integer',
        'li' => 'required|integer',
        'zhi' => 'required|integer',
        'xin' => 'required|integer',
        'score' => 'required|integer',
        'is_super_admin' => 'nullable|boolean',
        'current_team_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];


}
