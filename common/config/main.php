<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    "timeZone" => "Asia/Shanghai",
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
];
