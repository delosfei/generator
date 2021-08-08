<?php
return [
    'sms' => [
        'aliyun' =>
        [
            'sign' => '身份验证',
            'template' => 'SMS_12840367',
        ],
        'driver' => 'aliyun',
        'product' => NULL,
    ],
    'base' => [
        'icp' => NULL,
        'tel' => NULL,
        'email' => NULL,
        'title' => '后盾人',
        'keywords' => NULL,
        'copyright' => NULL,
        'description' => '后盾人在线教育',
    ],
    'user' =>
    [
        'bind' =>
        [],
        'avatar' => false,
        'wechatweb' =>
        [
            'appid' => NULL,
            'secret' => NULL,
        ],
        'wechat_appid' => NULL,
        'wechatweb_login' => false,
        'wechat_appsecret' => NULL,
    ],
    'email' =>
    [
        'host' => NULL,
        'port' => 80,
        'password' => NULL,
        'username' => NULL,
        'transport' => 'smtp',
        'encryption' => NULL,
    ],
    'wepay' =>
    [
        'key' => NULL,
        'mode' => NULL,
        'app_id' => NULL,
        'mch_id' => NULL,
        'cert_key' => NULL,
        'cert_client' => NULL,
    ],
    'alipay' =>
    [
        'mode' => NULL,
        'app_id' => NULL,
        'charset' => 'UTF-8',
        'sign_type' => NULL,
        'private_key' => NULL,
        'ali_public_key' => NULL,
    ],
    'aliyun' =>
    [
        'regionId' => 'cn-hangzhou',
        'accessKeyId' => NULL,
        'accessKeySecret' => NULL,
    ],
    'upload' =>
    [
        'oss' =>
        [
            'bucket' => NULL,
            'endpoint' => NULL,
        ],
        'local' =>
        [
            'path' => 'Y/m',
        ],
        'driver' => 'local',
        'file_size' => 200000000,
        'extensions' => 'jpg,jpeg,gif,png,doc,txt,pem',
    ],
];
