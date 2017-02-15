<?php

namespace frontend\assets;

use Yii; # ปิดการใช้งาน BootstrapAsset
use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IndexAsset extends AssetBundle {
    public $cssOptions = ['position' => \yii\web\View::POS_HEAD,];
    public $jsOptions = ['position' => \yii\web\View::POS_END/*'position' => View::POS_END*/];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=1.0',
        'vendor/css/font-awesome.min.css?v=1.0',
        'vendor/css/weather-icons.min.css?v=1.0',
        'vendor/css/demo.min.css?v=1.0',
        'vendor/css/typicons.min.css?v=1.0',
        'vendor/css/animate.min.css?v=1.0',
        'vendor/css/beyond.css?v=1.0',
        'vendor/css/skins/green.min.css?v=1.0',
        'vendor/css/responsive.bootstrap.min.css?v=1.0',
        'vendor/css/extra.css?v=1.0',
        'vendor/css/loader.css?v=1.0',
    ];
    public $js = [
        'vendor/js/skins.min.js?v=1.0',
        'vendor/js/slimscroll/jquery.slimscroll.min.js?v=1.0',
        'vendor/js/beyond.js?v=1.0',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}