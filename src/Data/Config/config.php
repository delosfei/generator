<?php
return [
    'name' => '{MODULE_NAME}',
    'title' => '{MODULE_TITLE}',
    'description' => '模块描述',
    'version' => 'v1.0.0',
    'author' => 'delosfei',
    'icon' => 'fas fa-futbol',
    'front' => true,
    'wechat' => [
        'subscribe' => [
            'isTextMessage',
            'isSubscribeEvent',
            'isScanEvent',
            'isImageMessage',
            'isButtonPicSysPhoto',
        ],
    ],
];
