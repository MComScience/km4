<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.53;dbname=km4',
            'username' => 'Andaman',
            'password' => 'Andaman_4221466',
            'charset' => 'utf8',
            'attributes' => [
                PDO::ATTR_PERSISTENT => true
            ]
        ],
        'db2' => [
            'class' => 'apaoww\oci8\Oci8DbConnection',
//            'dsn' => 'oci:dbname=//192.168.100.1/URCC',
            'dsn' => 'oci8:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.100.1)(PORT=1521))(CONNECT_DATA=(SID=URCC)));charset=AL32UTF8;', // Oracle
            'username' => 'SHIS',
            'password' => 'SHIS',
            'attributes' => [
                PDO::ATTR_STRINGIFY_FETCHES => true,
            ]
        // 'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'componentdate' => [
            'class' => 'common\components\DateComponent',
        ], 'finddata' => [
            'class' => 'common\components\FinddataComponent',
        ],
        'mailing' => [
            'class' => 'common\components\Mailing',
        ],
        'headertable' => [
            'class' => 'common\components\HeadertableComponent',
        ],
        'test' => [
            'class' => 'common\components\TestComponent',
        ],
        'chckauth' => [
            'class' => 'common\components\ChckAuth',
        ],
        'numberthai' => [
            'class' => 'common\components\NumberThai',
        ],
        'ssp' => [
            'class' => 'common\components\sspComponent',
        ],
        'logger' => [
            'class' => 'common\components\Logger',
        ],
        'thaiYearformat' => [
            'class' => 'common\components\ThaiYearFormat',
        ],
        'report' => [
            'class' => 'common\components\Report',
        ],
        'dateconvert' => [
            'class' => 'common\components\DateConvert',
        ],
        'genprnum' => [
            'class' => 'common\components\GeneratePRNum',
        ],
        'countstatus' => [
            'class' => 'common\components\CountStatus',
        ],
        'jasper' => [
            'class' => 'chrmorandi\jasper\Jasper',
            'db' => [
                'host' => '192.168.1.52',
                'port' => 3306,
                'driver' => 'mysql',
                'dbname' => 'km4',
                'username' => 'Andaman',
                'password' => 'Andaman_4221466'
            ]
        ],
    ],
];
