<?php

use yii\widgets\Breadcrumbs;
use common\themes\beyond\widgets\Alert;
use yii\helpers\Html;
?>
<div class="page-content">
    <!-- Page Breadcrumb -->
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                <?=
                Breadcrumbs::widget(
                        [
                            //'itemTemplate' => "<li><i class='fa fa-home'></i>{link}</li>\n",
                            'homeLink' => [
                                'label' => '<i class="fa fa-home"></i> ' . Yii::t('yii', 'Home'),
                                'url' => Yii::$app->homeUrl,
                                'encode' => false// Requested feature
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]
                )
                ?>
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <a class="sidebar-toggler" href="#">
                <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="">
                <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="#">
                <i class="glyphicon glyphicon-fullscreen"></i>
            </a>
        </div>
        <!--Header Buttons End-->
    </div>
    <!-- /Page Header -->
    <!-- Page Body -->
    <div class="page-body">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <!-- /Page Body -->
</div>
