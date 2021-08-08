<?php
return [
    [
        'title' => '系统管理',
        'items' => [
            ['title' => '网站配置', 'permission' => 'system-config'],
            ['title' => '管理员', 'permission' => 'system-admin'],
            ['title' => '角色管理', 'permission' => 'system-role'],
            ['title' => '权限列表', 'permission' => 'system-permission'],
            ['title' => '订单管理', 'permission' => 'order-role'],
        ]
    ],
    [
        'title' => '在线教育',
        'items' => [
            ['title' => '内容标签', 'permission' => 'edu-tag'],
            ['title' => '课程管理', 'permission' => 'edu-lesson'],
            ['title' => '视频管理', 'permission' => 'edu-lesson-video'],
            ['title' => '系统管理', 'permission' => 'edu-system-video'],
            ['title' => '发布课程', 'permission' => 'edu-lesson-create'],
            ['title' => '套餐设置', 'permission' => 'edu-subscribe'],
        ]
    ],
    [
        'title' => '其他',
        'items' => [
            ['title' => '贴子管理', 'permission' => 'topic-manage'],
        ]
    ]
];
