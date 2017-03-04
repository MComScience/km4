<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
use kartik\widgets\SideNav;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="widget">
            <?php
            echo SideNav::widget([
                'type' => SideNav::TYPE_DEFAULT,
                'encodeLabels' => false,
                'headingOptions' => ['class' => 'head-style'],
                'heading' => 'Manage Menus',
                'items' => [
                    //['label' => 'Add Menu', 'icon' => 'plus', 'url' => Url::to(['/menu/default/create']), 'active' => (Yii::$app->request->url == '/menu/default/create')],
                    ['label' => 'Lists Menu', 'icon' => 'list', 'url' => Url::to(['/menu']), 'active' => (Yii::$app->request->url == '/menu')],
                    //['label' => 'Add Category Menu', 'icon' => 'plus', 'url' => Url::to(['/menu/category/create']), 'active' => (Yii::$app->request->url == '/menu/category/create')],
                    ['label' => 'Lists Category Menu', 'icon' => 'list', 'url' => Url::to(['/menu/category']), 'active' => (Yii::$app->request->url == '/menu/category')],
                    ['label' => 'Sort Menu', 'icon' => 'move', 'url' => Url::to(['/menu/default/sorts']), 'active' => (Yii::$app->request->url == '/menu/default/sorts')],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.col -->


    <div class="col-lg-9 col-sm-6 col-xs-12">
        <?= $content ?>
        <!-- /. box -->
    </div>
    <!-- /.col -->


</div>


<?php $this->endContent(); ?>
