<?php

use Illuminate\Contracts\Container\BindingResolutionException;

if (!function_exists('image_random')) {
    /**
     * 生成随机图片
     * @return string
     */
    function image_random()
    {
        return "https://hdcms-dev.oss-cn-hangzhou.aliyuncs.com/images/b" . mt_rand(1, 110) . ".jpg";
    }
}


if (!function_exists('access')) {

    /**
     * 权限判断
     * @param mixed $permission
     * @return bool
     * @throws BindingResolutionException
     */
    function access($permission)
    {
        if (\Auth::check()) {
            return  \Auth::user()->can($permission);
        }
        return false;
    }
}
