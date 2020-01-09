<?php
return [
    'enable' => TRUE,
    'middleware' => 'web',
    'providers' => [
        'default' => [
            'enable' => TRUE,
            'languages' => [
                'en' => 'English',
                'zh-CN' => '简体中文',
            ],
            // default locale
            'default' => 'en',
            'is_api' => FALSE,
            'path' => '/',
            'domain' => NULL,
        ],
    ],
];
