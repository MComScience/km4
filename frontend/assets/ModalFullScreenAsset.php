<?php 

namespace frontend\assets;

use yii\web\AssetBundle;

class ModalFullScreenAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
        'vendor/modal-fullscreen/modal-fullscreen.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];
    
   public function init() {
       // In dev mode use non-minified javascripts
       $this->js = YII_DEBUG ? [
           'vendor/modal-fullscreen/modal-fullscreen.js',
       ]:[
           'vendor/modal-fullscreen/modal-fullscreen.js',
       ];

       parent::init();
   }
}
