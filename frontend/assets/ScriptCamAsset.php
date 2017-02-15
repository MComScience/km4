<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ScriptCamAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'vendor/ScriptCam/swfobject.js?v=2.2',
        'vendor/ScriptCam/scriptcam.js?v=2.2'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
