<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "รับสินค้าขอยืม";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
    <div class="tabbable">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="tab-content">
            <div id="tab" class="tab-pane in active ">
                <div class="tb-gr2-temp-index">
                    <?php Pjax::begin(['id'=>'lond_product','timeout' => 5000]) ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?php // Html::a(Yii::t('app', 'Create Tb Po2 Temp'), ['create'], ['class' => 'btn btn-success']) ?>
                <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'toggleData' => true,
                        'layout' => Yii::$app->componentdate->layoutgridview(),
                        'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => 'ลำดับ',
                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'เลขที่ใบรับสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->GRNum == null) {
                                        return '-';
                                    } else {
                                        return $model->GRNum;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'วันที่รับสินค้า',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->GRDate == null) {
                                        return '-';
                                    } else {
                                        return $model->GRDate;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'เลขที่ผู้ให้ยืม',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->VenderID == null) {
                                        return '-';
                                    } else {
                                        return $model->VenderID;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ชื่อผู้ให้ยืม',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->VenderID == null) {
                                        return '-';
                                    } else {
                                        return $model->datavender->VenderName;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'สถานะการรับสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->status->GRStatusDesc == null) {
                                        return '-';
                                    } else {
                                        return $model->status->GRStatusDesc;
                                    }
                                }
                            ],
                                     [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:140px;'],
                                'header' => 'Actions',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'template' => '{update} {delete} {manage}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        if($model->GRNum != null){
                                        return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url, [
                                                    'title' => Yii::t('app', 'Edit'),
                                        ]);
                                        }
                                    },
                                    'delete' => function ($url, $model) {
                                        if($model->GRNum != null){
                                        return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', $url, [
                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-method' => "post",
                                                    'role' => 'modal-remote',
                                        ]);
                                        }
                                    },
                                    'manage' => function ($url, $model) {
                                        if($model->GRNum == null){
                                        return '<span style="color:#53a93f;">กำลังดำเนินการ</span><span class="glyphicon glyphicon-hourglass" style="color:#53a93f;"></span>';
                                        }
                                        
                                    },
                                        ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                        if ($action === 'update') {
                                                return Url::to(['create', 'GRID' => $model->GRID,'view' => '']);
                                        }
                                       if ($action === 'delete') {//Delete
                                            return Url::to(['delete', 'id' => $model->GRID]);
                                        }
                                    }
                                ],
                                    
                        ]
                    ]);
                ?>
                <?php Pjax::end() ?>
                </div>
            </div>
            <br>
            <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard/index" class="btn btn-default">Close</a>
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
