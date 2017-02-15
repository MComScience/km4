<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LaddaAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/ladda/dist/ladda-themeless.min.css'
    ];
    public $js = [
        'vendor/ladda/dist/spin.min.js',
        'vendor/ladda/dist/ladda.min.js',
        'vendor/ladda/dist/ladda.jquery.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset',
    ];
}