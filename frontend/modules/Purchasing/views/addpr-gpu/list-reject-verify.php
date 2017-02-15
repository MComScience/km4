<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'ใบขอซื้อไม่ผ่านการทวนสอบ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;


$script = <<< JS
$(document).ready(function () {
        $('#list-reject-verify').addClass("active");
        $('#tab_C').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="รายการใบขอซื้อ" class="tab-pane in active">
                    <div class="tb-pr2-temp-index">
                        <?php Pjax::begin([ 'timeout' => 5000, 'id' => 'list-reject-verify']) ?>
                        <?php echo $this->render('_search_detail', ['model' => $searchModel,'action' => 'list-reject-verify']); ?>
                        <p></p>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            'striped' => false,
                            'condensed' => true,
                            'toggleData' => false,
                            'layout' => $layout,
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
                                ],
                                [
                                    'header' => 'เลขที่ใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRNum',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'วันที่',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRDate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ประเภทใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRTypeID',
                                    'value' => 'prtype.PRType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'POTypeID',
                                    'value' => 'potype.POType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'กำหนดเวลาการส่งมอบ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRExpectDate',
                                    //'format' => 'raw',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function($model) {
                                return 'ภายใน ' . $model->PRExpectDate . ' วัน';
                            }
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    //'contentOptions' => ['style' => 'width:260px;'],
                                    'options' => ['style' => 'width:160px;'],
                                    'header' => 'Actions',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{view}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        //view button
                                        'view' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
                                                        'title' => 'Select',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                            	$val = base64_encode($model->PRNum);
                                        if ($model->PRTypeID == 1) {//ยาสามัญ
                                            
                                            if ($action === 'view') {
                                                return Url::to(['update-resend-verify', 'id' => $key, 'view' => $val]);
                                            }
                                        } elseif ($model->PRTypeID == 2) {
                                            if ($action === 'view') {
                                                return Url::to(['addpr-tpu/update-resend-verify', 'id' => $key, 'view' => $val]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {
                                            if ($action === 'view') {
                                                return Url::to(['addpr-nd/update-resend-verify', 'id' => $key, 'view' => $val]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'view') {
                                                return Url::to(['addpr-tpu-cont/update-resend-verify', 'id' => $key, 'view' => $val]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {
                                            if ($action === 'view') {
                                                return Url::to(['addpr-nd-cont/update-resend-verify', 'id' => $key, 'view' => $val]);
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