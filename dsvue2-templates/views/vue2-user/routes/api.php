<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;


Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('forget-password', [ForgetPasswordController::class, 'handle']);

//图形验证码
Route::get('captcha', [CaptchaController::class, 'make']);

//用户
Route::get('user/info', [UserController::class, 'info'])->middleware(['auth:sanctum']);
Route::get('user/roles/{user}', [UserController::class, 'roles'])->middleware(['auth:sanctum']);
Route::post('user/roles/{user}', [UserController::class, 'syncRoles'])->middleware(['auth:sanctum']);
Route::apiResource('user', UserController::class)->middleware(['auth:sanctum']);

