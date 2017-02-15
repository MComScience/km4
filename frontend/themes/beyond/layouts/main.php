<?php

use yii\helpers\Html;
use common\themes\beyond\web\BeyondAsset;

if (Yii::$app->controller->action->id === 'login' || Yii::$app->controller->action->id === 'request' || Yii::$app->controller->action->id === 'resend' || Yii::$app->controller->action->id === 'reset') {
    /**
     * Do not use this code in your template. Remove it. 
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {
    $username = Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname;
    Yii::$app->chckauth->AuthUpdate();
    if (class_exists('frontend\assets\AppAsset')) {
        frontend\assets\AppAsset::register($this);
    } else {
        //app\assets\AppAsset::register($this);
    }

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
            <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | KM4' : null); ?></title>
            <script type="text/javascript">
                var baseUrl = '<?php echo \Yii::$app->urlManager->createAbsoluteUrl(['/']); ?>';
            </script>
            <?php $this->head() ?>
        </head>
        <body>
            <?php $this->beginBody() ?>
            <div class="loading-container">
                <div class="loader"></div>
            </div>
            <?=
            $this->render(
                    'header.php', ['directoryAsset' => $directoryAsset, 'username' => $username]
            )
            ?>
            <!-- Main Container -->
            <div class="main-container container-fluid">
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
                    <?= \bluezed\scrollTop\ScrollTop::widget() ?>
                </div>
            </div>
            
            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
