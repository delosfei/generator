<?php
return [
    [
        'title' => '基础设置',
        'icon' => 'fab fa-app-store-ios',
        'show' => true,
        'items' => [
            ['title' => '模块配置', 'permission' => 'config'],
            ['title' => '内容标签', 'permission' => 'tag'],
        ],
    ],
    [
        'title' => '模块菜单1',
        'icon' => 'fas fa-camera',
        'show' => true,
        'items' => [
            ['title' => '模块菜单1子菜单1', 'permission' => 'lesson'],
            ['title' => '模块菜单1子菜单2', 'permission' => 'lesson'],
        ],
    ],

];
