<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ใบเคลมสินค้ารอรับเข้า";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
    });
JS;
$this->registerJs($script);
?>
    <div class="tabbable">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="tab-content">
            <div id="tab" class="tab-pane in active ">
                <div class="tb-st2-temp-index">
                    <?php Pjax::begin([ 'timeout' => 5000]) ?>
                    <?php echo $this->render('_search_claim', ['model' => $searchModel]); ?>
                    <?php // Html::a(Yii::t('app', 'Create Tb Po2 Temp'), ['create'], ['class' => 'btn btn-success']) ?>
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => true,
                        'condensed' => true,
                        'toggleData' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '<a>ลำดับ</a>',
                                'headerOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'header' => '<a>เลขที่ใบโอนสินค้า</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->STNum == null) {
                                        return '-';
                                    } else {
                                        return $model->STNum;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'STDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'Stk_issue',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->Stk_issue == null) {
                                        return '-';
                                    } else {
                                        return $model->Stk_issue;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'header' => '<a>ชื่อผู้ขาย</a>',
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
                                'attribute' => 'STDueDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'STStatusDesc',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->STStatusDesc == null) {
                                        return '-';
                                    } else {
                                        return $model->STStatusDesc;
                                    }
                                }
                            ],
                                     [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:140px;'],
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs">Detail</span>', $url, [
                                                    'title' => Yii::t('app', 'Detail'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url, [
                                                    'title' => Yii::t('app', 'Edit'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', $url, [
                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-method' => "post",
                                                    'role' => 'modal-remote',
                                        ]);
                                    },
                                        ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                        if ($action === 'view') {//Delete
                                            return Url::to(['create', 'STID' => $model->STID,'view'=>'view']);
                                        }
                                        if ($action === 'update') {
                                                return Url::to(['create', 'STID' => $model->STID,'view' => '']);
                                        }
                                       if ($action === 'delete') {//Delete
                                            return Url::to(['delete', 'id' => $model->STID]);
                                        }
                                    }
                                ],
                                    
                        ]
                    ]);
                ?>
                <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-space"></div>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                 <?php
                 echo \kartik\widgets\Growl::widget([
                     'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                     'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                     'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                     'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                     'showSeparator' => true,
                     'delay' => 1, //This delay is how long before the message shows
                     'pluginOptions' => [
                         'delay' => (!empty($message['duration'])) ? $message['duration'] : 2000, //This delay is how long the message shows for
                         'placement' => [
                             'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                             'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                         ]
                     ]
                 ]);
                 ?>
         <?php endforeach; ?>
