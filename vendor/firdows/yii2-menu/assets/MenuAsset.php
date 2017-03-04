<?php

namespace firdows\menu\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MenuAsset extends AssetBundle {

    public $sourcePath = '@firdows/menu/assets';
    public $css = [
        'toastr/build/toastr.min.css'
    ];
    public $js = [
        'js/jquery.nestable.min.js',
        'js/config.js',
        'toastr/build/toastr.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
