<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Purchasing\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'รับสินค้าจากการสั่งซื้อ');
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="tab" class="tab-pane in active ">
                    <div class="tb-gr2-temp-index">
                        <?php Pjax::begin(['timeout' => 5000]) ?>
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => true,
                            'condensed' => true,
                            'toggleData' => false,
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PONum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->PONum == null) {
                                    return '-';
                                } else {
                                    return $model->PONum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'POContID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->POContID == null) {
                                    return '-';
                                } else {
                                    return $model->POContID;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PODate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PRNum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->PRNum == null) {
                                    return '-';
                                } else {
                                    return $model->PRNum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'VendorID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->VendorID == null) {
                                    return '-';
                                } else {
                                    return $model->VendorID;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'VenderName',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->VenderName == null) {
                                    return '-';
                                } else {
                                    return $model->VenderName;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'POType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->POType == null) {
                                    return '-';
                                } else {
                                    return $model->POType;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PODueDate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<a>Actions</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {

                                            if ($model->WIPGR == 1) {
                                                return Html::a('<span class="btn btn-info btn-sm"> On Process </span>', $url, [
                                                            'title' => Yii::t('app', 'On Process'),
                                                ]);
                                            } else {
                                                return Html::a('<span class="btn btn-primary btn-sm"> สร้างใบรับสินค้า </span>', $url, [
                                                            'title' => Yii::t('app', 'สร้างใบรับสินค้า'),
                                                ]);
                                            }
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        //Update
                                        if ($model->PRTypeID == 1 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {//ยาสามัญ
                                            if ($action === 'update') {
                                                return Url::to(['create', 'poid' => $model['POID'], 'ponum' => $model['PONum'], 'view' => 'false']);
                                            }
                                        } elseif ($model->PRTypeID == 2 || $model->PRTypeID == 6 || $model->PRTypeID == 9) {//ยาการค้า
                                            if ($action === 'update') {
                                                return Url::to(['create', 'poid' => $model['POID'], 'ponum' => $model['PONum'], 'view' => 'false']);
                                            }
                                        }
                                    }
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>
