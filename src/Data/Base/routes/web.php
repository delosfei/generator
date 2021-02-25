<?php

use App\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;

Route::get('/', function () {
    return '网站主页';
});

// Route::get('a', function () {
//     dd(\Cache::get(\CodeService::cacheName('2300071698@qq.com')));
// });
// Route::get('{app}', function () {
//     return view('app');
// })->where('app', 'login|register|admin')->middleware(['guest']);

//后备路由（没有可匹配路由时执行这里）
Route::fallback(function () {
    return view('app');
});
