<?php
/*
 * 2014-11-07
 * @author Prawee Wongsa <konkeanweb@gmail.com>
 * 
 */
namespace prawee\assets;

use yii\web\AssetBundle;
class PwAsset extends AssetBundle
{
    /*
     * @inheritdoc
     */
    public $sourcePath='@prawee/assets';

    /*
     * @inheritdoc
     */
    public $css=[
        'css/gridview.css'
    ];

    /*
     * @inheritdoc
     */
    public $js=[
        'js/bootbox.min.js',
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
