<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function message($message, $code = 0, $data = [])
    {
        return [
            'message' => $message,
            'code' => $code,
            'data' => $data
        ];
    }

    public function error($message, $httpCode)
    {
        return response(['message' => $message, $httpCode]);
    }
}
