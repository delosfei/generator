<?php

use Modules\Article\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => '{MODULE_NAME}/site/{site}', 'as' => '{MODULE_LOWER_NAME}.'],
    function () {

        Route::get('/', [HomeController::class, 'home'])->middleware(['module']);

    }
);

