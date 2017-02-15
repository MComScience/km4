<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AutoNumericAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'vendor/autoNumeric/autoNumeric.js',
        'vendor/autoNumeric/addCommas.js',
        'vendor/autoNumeric/price_format.min.js?v=1.0',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}