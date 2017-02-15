<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SweetAlertAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/sweetalert-master/dist/sweetalert.css'
    ];
    public $js = [
        'vendor/sweetalert-master/dist/sweetalert.min.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
