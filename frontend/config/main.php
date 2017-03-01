<?php

use \yii\web\Request;

$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'KM4 Medical Software',
    'language' => 'th-TH', // เปิดใช้งานภาษาไทย
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        # Yii2-User Extension
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['mcomscience'], #'admin',
//            'mailer' => [
//                'sender' => ['procurementuch@gmail.com' => 'KM4'], // or ['no-reply@myhost.com' => 'Sender name']
//                'welcomeSubject' => 'Welcome subject',
//                'confirmationSubject' => 'Confirmation subject',
//                'reconfirmationSubject' => 'Email change subject',
//                'recoverySubject' => 'Recovery Password',
//            ],
            /*
            'controllerMap' => [
                'admin' => [
                    'class' => common\themes\beyond\controllers\AdminController::className(),
                ],
                'profile' => [
                    'class' => common\themes\beyond\controllers\ProfileController::className(),
                ],
                'recovery' => [
                    'class' => common\themes\beyond\controllers\RecoveryController::className(),
                ],
                'registration' => [
                    'class' => common\themes\beyond\controllers\RegistrationController::className(),
                ],
                'security' => [
                    'class' => common\themes\beyond\controllers\SecurityController::className(),
                ],
                'settings' => [
                    'class' => common\themes\beyond\controllers\SettingsController::className(),
                ],
            ],*/
            /*
            'modelMap' => [
                'Account' => [
                    'class' => '\common\themes\beyond\models\Account',
                ],
                'LoginForm' => [
                    'class' => '\common\themes\beyond\models\LoginForm',
                ],
                'Profile' => [
                    'class' => '\common\themes\beyond\models\Profile',
                ],
                'RegistrationForm' => [
                    'class' => '\common\themes\beyond\models\RegistrationForm',
                ],
//                'ResendForm' => [
//                    'class' => '\common\themes\beyond\models\ResendForm',
//                ],
//                'SettingsForm' => [
//                    'class' => '\common\themes\beyond\models\SettingsForm',
//                ],
                'User' => [
                    'class' => '\common\themes\beyond\models\User',
                ],
                'UserSearch' => [
                    'class' => '\common\themes\beyond\models\UserSearch',
                ],
            ],*/
        ],
        # Yii2-Admin Extension
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu', // left-menu, right-menu, top-menu
            'menus' => [
                'assignment' => [
                    'label' => 'Assignments' // change label
                ],
                'role' => [
                    'label' => 'Roles' // change label
                ],
                'permission' => [
                    'label' => 'Permissions' // change label
                ],
                'route' => [
                    'label' => 'Routes' // change label
                ],
                'rule' => [
                    'label' => 'Rules' // change label
                ],
            //'route' => null, // disable menu
            ],
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'Inventory' => [
            'class' => 'app\modules\Inventory\Inventory',
        ],
        'Purchasing' => [
            'class' => 'app\modules\Purchasing\Purchasing',
        ],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module'
        ],
        'Outpatientdepartment' => [
            'class' => 'app\modules\Outpatientdepartment\Module',
        ],
        'Report' => [
            'class' => 'app\modules\Report\Module',
        ],
        'AuthenticationandFinance' => [
            'class' => 'app\modules\AuthenticationandFinance\AuthenticationandFinance',
        ],
        'Payment' => [
            'class' => 'app\modules\Payment\Payment',
        ],
        'cpoe' => [
            'class' => 'app\modules\drugorder\Module',
        ],
        'dispense' => [
            'class' => 'app\modules\dispense\Module',
        ],
        'cpoes' => [
            'class' => 'app\modules\drugorders\Module',
        ],
        'purqr' => [
            'class' => 'app\modules\purqr\Module',
        ],
        'menu' => [
            'class' => 'firdows\menu\Module',
        ],
        'chemo' => [
            'class' => 'app\modules\chemo\Module',
        ],
        'pharmacy' => [
            'class' => 'app\modules\pharmacy\Module',
        ],
        'pr' => [
            'class' => 'app\modules\pr\Module',
        ],
        'po' => [
            'class' => 'app\modules\po\Module',
        ],
        'plan' => [
            'class' => 'app\modules\plan\Module',
        ],
    ],
    'components' => [
        'request' => [
            //'csrfParam' => '_csrf-frontend',
            'baseUrl' => $baseUrl,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:j M Y',
            'datetimeFormat' => 'php:j M Y H:i',
            'timeFormat' => 'php:H:i',
            'timeZone' => 'Asia/Bangkok'
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        /*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@frontend/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com', #gmail
                'username' => 'procurementuch@gmail.com', #gmail
                'password' => 'pro123456', #gmail
                'port' => '465', #gmail port 465 สำหรับ ssl ,port 587 สำหรับ tls
                'encryption' => 'ssl', #tls
            ],
        ],*/
        # Yii2-User Extension
        'user' => [
            'identityClass' => 'dektrium\user\models\User', // or 'common\models\User'
            'identityCookie' => [
                'name' => '_frontendIdentity',
                'path' => '/',
                'httpOnly' => true
            ],
            'enableAutoLogin' => true,
        //'authTimeout' => 16000,
        ],
        # Yii2-User Extension
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path' => '/',
            //'lifetime' => 60,
            ],
            'timeout' => 3600 * 3,
        ],
        # Virtual Host
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false, // Disable index.php
            'enablePrettyUrl' => true, // Disable r= routes
            'rules' => [
                'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                'pr_approve' => 'pr/default/approve',
                '<controller:\w+>/<id:\d+>' => '<controller>',
                '<controller:\w+>/<action:\w+>/<*:*>' => '<controller>/<action>/<*>',
                '<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<*:*>' => '<module>/<controller>/<action>/<*>',
            ],
        ],
        # ติดตั้ง Theme beyond
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@frontend/views' => '@frontend/themes/beyond',
                    //'@dektrium/user/views' => '@common/themes/beyond/views/user',
                ],
            ],
        ],
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
            'user/security/login',
            'user/recovery/request',
            'user/recovery/reset',
            'user/registration/regis',
            'user/registration/confirm',
            'user/recover/*'
        //'admin/*'
        ]
    ],
    'params' => $params,
];
