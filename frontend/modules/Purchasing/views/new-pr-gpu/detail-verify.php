<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Purchasing\models\TbPr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ใบขอซื้อรอทวนสอบ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <li class="tab-success active">
                <a data-toggle="tab" href="#home">
                    <?= Html::encode('ใบขอซื้อรอการทวนสอบ') ?>
                </a>
            </li>
        </ul>
        <div class="tab-content bg-white">
            <div id="home" class="tab-pane in active">
                <div class="tb-pr2-temp-index">
                    <?php Pjax::begin([ 'timeout' => 5000]) ?>
                    <?php echo $this->render('_search_detail_verify', ['model' => $searchModel]); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        //'showPageSummary' => true,
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
                                'header' => '<a>ลำดับ</a>',
                                'headerOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            [
                                'attribute' => 'PRNum',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'attribute' => 'PRDate',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'attribute' => 'PRTypeID',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'value' => 'prtype.PRType',
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'attribute' => 'POTypeID',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'value' => 'potype.POType',
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'attribute' => 'PRExpectDate',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
//                            [
//                                'attribute' => 'PRStatusID',
//                                'headerOptions' => ['style' => 'text-align:center'],
//                                'hAlign' => GridView::ALIGN_CENTER,
//                            ],
//                            [
//                                'header' => 'สถานะการขอซื้อ',
//                                'attribute' => 'PRStatusID',
//                                'value' => 'prstatus.PRStatus',
//                                'hAlign' => GridView::ALIGN_CENTER,
//                            ],
//                        [ // แสดงข้อมูลออกเป็น icon
//                            'header' => 'สถานะการขอซื้อ',
//                            'attribute' => 'PRStatusID',
//                            'format' => 'html',
//                            'hAlign' => GridView::ALIGN_CENTER,
//                            'value' => function($model, $key, $index, $column) {
//                                return '<a class="btn btn-warning btn-xs"><i class="glyphicon glyphicon glyphicon-hourglass"></i>รอการทวนสอบ</a>';
//                            }
//                        ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:160px;'],
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => '{view}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    //view button
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
                                                    'title' => Yii::t('app', 'Verify'),
                                        ]);
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($model->PRTypeID == 1 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {//ยาสามัญ
                                        if ($action === 'view') {
                                            return Url::to(['update-detail-verify', 'id' => $key, 'view' => 'false']);
                                        }
                                    } elseif ($model->PRTypeID == 2 || $model->PRTypeID == 6 || $model->PRTypeID == 9) {//ยาการค้า
                                        if ($action === 'view') {
                                            return Url::to(['new-pr-tpu/update-detail-verify', 'id' => $key, 'view' => 'false']);
                                        }
                                    } elseif ($model->PRTypeID == 3 || $model->PRTypeID == 7 || $model->PRTypeID == 10) {//เวชภัณฑ์
                                        if ($action === 'view') {
                                            return Url::to(['new-pr-nd/update-detail-verify', 'id' => $key, 'view' => 'false']);
                                        }
                                    } elseif ($model->PRTypeID == 11) {
                                        if ($action === 'view') {
                                            return Url::to(['addpr-tpu-cont/update-detail-verify', 'id' => $key, 'view' => 'false']);
                                        }
                                    } elseif ($model->PRTypeID == 12) {
                                        if ($action === 'view') {
                                            return Url::to(['addpr-nd-cont/update-detail-verify', 'id' => $key, 'view' => 'false']);
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