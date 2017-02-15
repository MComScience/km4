<?php
namespace common\components\beyondadmin\web;

use yii\base\Exception;
use yii\web\AssetBundle as BaseBeyondAdminAsset;

class BeyondAdminAsset extends BaseBeyondAdminAsset
{
    public $sourcePath = '@common/components/beyondadmin/dist';
    public $css = [
        'css/font-awesome.min.css?v=1.0',
        'css/weather-icons.min.css?v=1.0',
        'css/demo.min.css?v=1.0',
        'css/typicons.min.css?v=1.0',
        'css/animate.min.css?v=1.0',
        'css/beyond.css?v=2.0',
        //'css/skins/green.min.css',
    ];
    public $js = [
        'js/skins.min.js?v=1.0',
        'js/slimscroll/jquery.slimscroll.min.js?v=1.0',
        'js/beyond.js',
        'js/smoothscroll.js?v=1.0',
    ];
    public $depends = [
       // 'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $skin = 'skin-green';

    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('skin-green' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}
