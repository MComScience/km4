<?php

use common\themes\beyond\web\BeyondAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

BeyondAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@common/themes/beyond/assets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= $directoryAsset ?>/img/favicon.png" type="image/x-icon">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="navbar-container">
                    <!-- Navbar Barnd -->
                    <div class="navbar-header pull-left">
                        <a href="/km4" class="navbar-brand">
                            <small>
                                <img src="<?= $directoryAsset ?>/img/rsz_logokm4-2.png" alt="" />
                            </small>
                        </a>
                    </div>
                    <!-- /Navbar Barnd -->
                </div>
            </div>
        </div>
        <?= $content ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
