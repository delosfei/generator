<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 响应成功消息
     * @param mixed $data
     * @param string $message
     * @return array
     */
    protected function success(string $message, $data = null)
    {
        return [
            'message' => $message,
            'data' => $data,
        ];
    }
}
