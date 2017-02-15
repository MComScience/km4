<?php
namespace frontend\modules\pr\assets;

use yii\web\AssetBundle;

class GpuAsset extends AssetBundle
{
    public $sourcePath = '@frontend/modules/pr/assets';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/tab_menu.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset',
    ];
}
