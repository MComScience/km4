<?php

use yii\helpers\Html;
use common\themes\beyond\web\BeyondAsset;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it. 
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
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
            <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300"
                  rel="stylesheet" type="text/css">
                  <?= Html::csrfMetaTags() ?>
            <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | ' : null); ?>KM4</title>
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
                    'header.php', ['directoryAsset' => $directoryAsset]
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

                </div>
            </div>
            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
