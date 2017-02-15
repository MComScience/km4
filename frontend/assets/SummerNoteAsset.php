<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SummerNoteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/summernote/dist/summernote.css?v=1.0',
    ];
    public $js = [
        'vendor/summernote/dist/summernote.js?v=1.0',
        'vendor/summernote/dist/summernote-ext-print.js?v=1.0',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
