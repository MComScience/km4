<?php
namespace common\themes\beyond\web;

use yii\base\Exception;
use yii\web\AssetBundle as BaseBeyondAsset;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class BeyondAsset extends BaseBeyondAsset
{
    public $sourcePath = '@common/themes/beyond/assets/';
    public $css = [
        'css/font-awesome-4.6.3/css/font-awesome.min.css?v=1.0',
        'css/weather-icons.min.css?v=1.0',
        'css/beyond.css?v=1.0',
        'css/typicons.min.css?v=1.0',
        'css/animate.min.css?v=1.0'
    ];
    public $js = [
        'js/skins.min.js?v=1.0',
        'js/slimscroll/jquery.slimscroll.min.js?v=1.0',
        'js/beyond.min.js?v=1.0',
        'js/smoothscroll.js?v=1.0'
    ];
    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = 'skin-green';

    /**
     * @inheritdoc
     */
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
