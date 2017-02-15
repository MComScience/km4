<?php

use common\components\beyondadmin\web\BeyondAdminAsset;
use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    BeyondAdminAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@common/components/beyondadmin/dist');
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
        <body>
            <?php $this->beginBody() ?>
            <div class="loading-container">
                <div class="loader"></div>
            </div> 

            <?=
            $this->render(
                    'header.php', ['directoryAsset' => $directoryAsset]
            )
            ?>
            <div class="main-container container-fluid">
                <!-- Page Container -->
                <div class="page-container">
                    <?=
                    $this->render(
                            'left.php', ['directoryAsset' => $directoryAsset]
                    )
                    ?>

                    <?=
                    $this->render(
                            'content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]
                    )
                    ?>

                </div>
            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
