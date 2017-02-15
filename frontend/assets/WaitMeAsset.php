<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WaitMeAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/waitMe/waitMe.min.css?v=1.0',
    ];
    public $js = [
        'vendor/waitMe/waitMe.min.js?v=1.0',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
