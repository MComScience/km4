<?php

use yii\widgets\Breadcrumbs;
use common\components\beyondadmin\widgets\Alert;
use yii\helpers\Html;
?>
<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '<i class="fa fa-home"></i> ' . Yii::t('yii', 'Home'),
                        'url' => Yii::$app->homeUrl,
                        'encode' => false// Requested feature
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <?= Html::a('<i class="fa fa-arrows-h"></i>', '#', ['class' => 'sidebar-toggler']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-refresh"></i>', [''], ['class' => 'refresh', 'id' => 'refresh-toggler']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-fullscreen"></i>', '#', ['class' => 'fullscreen', 'id' => 'fullscreen-toggler']) ?>
        </div>
        <!--Header Buttons End-->
    </div>
    <div class="page-body">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->