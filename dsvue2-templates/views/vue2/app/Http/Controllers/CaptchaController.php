<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Captcha;

/**
 * 验证码
 * @package App\Http\Controllers
 */
class CaptchaController extends Controller
{
    public function make()
    {
        return \Captcha::create('default', true);
    }
}
