<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    # ตั้งค่าการใช้งานภาษาไทย (Language)
    'language' => 'th-TH', // ตั้งค่าภาษาไทย
    # ตั้งค่า TimeZone ประเทศไทย
    'timeZone' => 'Asia/Bangkok', // ตั้งค่า TimeZone
    # Yii2-Admin Extension
    'aliases' => [
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin'
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i a',
            'timeFormat' => 'php:H:i A',
            'timeZone' => 'Asia/Bangkok',
        ]
    ],
    'params' => [
        'icon-framework' => 'fa', // Font Awesome Icon framework
    ],
    'modules' => [
        # Yii2-User Extension
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true, // ไม่ต้องยืนยันการสมัครก็ล๊อกอินได้
            // 'enableConfirmation' => false, // true เปิด / false ปิด ระบบส่งอีเมลล์ ยืนยันการสมัครสมาชิก
            'confirmWithin' => 21600,
            'cost' => 12,
        //'admins' => ['admin']  // admin หมายถึง user ที่ถือสิทธิ์ Administration อยู่
        ],
        
    ]
];
