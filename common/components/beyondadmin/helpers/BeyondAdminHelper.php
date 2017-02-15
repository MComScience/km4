<?php
namespace common\components\beyondadmin\helpers;

use Yii;

class BeyondAdminHelper
{
    /**
     * It allows you to get the name of the css class.
     * You can add the appropriate class to the body tag for dynamic change the template's appearance.
     * Note: Use this fucntion only if you override the skin through configuration. 
     * Otherwise you will not get the correct css class of body.
     * 
     * @return string
     */
    public static function skinClass()
    {
        /** @var \dmstr\web\AdminLteAsset $bundle */
        $bundle = Yii::$app->assetManager->getBundle('common\components\beyondadmin\web\BeyondAdminAsset');

        return $bundle->skin;
    }
}