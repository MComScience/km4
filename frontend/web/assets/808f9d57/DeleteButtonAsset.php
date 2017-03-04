<?php
/*
 * 2014-11-07
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * 
 */
namespace common\themes\beyond\assets;

use yii\web\AssetBundle;
class DeleteButtonAsset extends AssetBundle
{
    /*
     * @inheritdoc
     */
    public $sourcePath='@common/themes/beyond/assets';

    /*
     * @inheritdoc
     */
    public $css = [
        'sweetalert-master/dist/sweetalert.css',
    ];
    
    public $js=[
        'sweetalert-master/dist/sweetalert.min.js',
        'js/confirm.js'
    ];

    /*
     * @inheritdoc
     */
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
