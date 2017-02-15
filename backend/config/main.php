<?php

//use \yii\web\Request;
//$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());
//$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());
$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
        // other module settings
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        // other module settings
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'Config' => [
            'class' => 'app\modules\Config\Inventory',
        ],
        'Inventory' => [
            'class' => 'app\modules\Inventory\Inventory',
        ],
        'Purchasing' => [
            'class' => 'app\modules\Purchasing\Plan',
        ],
        'Opdandipd' => [
            'class' => 'app\modules\Receipopdandipd\opdandipd',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
//         'request' => [
//            'baseUrl' => $baseUrl,
//        ],
        /* 'authManager' => [
          'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
          ], */
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        //'request' => [
        //  'baseUrl' => $baseUrl,
        //  ],
        'urlManager' => [
//            'showScriptName' => false, // Disable index.php
//            'enablePrettyUrl' => true, // Disable r= routes
//            'enableStrictParsing' => true,
            'rules' => [
//                [
//                'class' => 'common\components\UrlRule','connectionID' => 'km4',],
                '' => 'site/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
              //  ['class' => 'yii\rest\UrlRule', 'controller' => 'location'],
            ],
        ],
//        'user' => [
//            //'identityClass' => 'app\models\User',
//            'identityClass' => 'dektrium\user\models\User',
//            'enableAutoLogin' => true,
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
        // 'site/*',
        // 'admin/*',
        // '*',
        // The actions listed here will be allowed to everyone including guests.
        // So, 'admin/*' should not appear here in the production, of course.
        // But in the earlier stages of your development, you may probably want to
        // add a lot of actions here until you finally completed setting up rbac,
        // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];
