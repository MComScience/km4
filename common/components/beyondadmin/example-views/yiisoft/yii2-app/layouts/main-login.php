<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use common\components\beyondadmin\web\BeyondAdminAsset;

BeyondAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="login-page">

        <?php $this->beginBody() ?>

        <?= $content ?>  

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
