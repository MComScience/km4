<?php

use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\helpers\Html;

#register assets
CrudAsset::register($this);

$this->title = 'Create Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.kv-grid-table thead tr th{
        background-color: #ddd;
        text-align: center;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#content1">
                        <?= Html::encode('Create Standard Regimen') ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="content1" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <?php // echo $this->render('_form_std_index', ['modelHeader' => $model]); ?> 
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <?php
                            echo $this->render('_form_std_detail', [
                                'model' => $detailmodel,
                                'drugset_id' => $drugset_id,
                                'keepProvider' => $keepProvider, #เปิดเส้น
                                'premedProvider' => $premedProvider,
                                'medicatProvider' => $medicatProvider,
                                'ivProvider' => $ivProvider,
                                'modelHeader' => $model,
                            ]);
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<?php
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        //'closeButton' => false,
]);
?>
<div id="data"></div>
<?php Modal::end(); ?>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php Modal::end(); ?>

