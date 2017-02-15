<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$this->title = 'รายการใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['index']];
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
                    <div class="tb-po2-temp-index">
                        <?php Pjax::begin(['timeout' => 5000]) ?>
                        <?php echo $this->render('_search', ['model' => $searchModel, 'action' => 'index']); ?>
                        <p></p>
                        <?php // Html::a(Yii::t('app', 'Create Tb Po2 Temp'), ['create'], ['class' => 'btn btn-success'])   ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            'pjax' => true,
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
                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                ],
                                    [
                                    'header' => 'เลขที่ใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
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
                                    'header' => 'วันที่ใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRDate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                    [
                                    'header' => 'ประเภทการขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->PRType == null) {
                                            return '-';
                                        } else {
                                            return $model->PRType;
                                        }
                                    }
                                ],
                                    [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'POType',
                                    //'header' => '',
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
                                    'header' => 'กำหนดเวลาการส่งมอบ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRExpectDate',
                                    //'header' => 'วันที่ต้องการสินค้า',
                                    //'format' => ['date', 'php:d-m-Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function($model) {
                                        return 'ภายใน ' . $model->PRExpectDate . ' วัน';
                                    }
                                ],
                                /*
                                  [
                                  'header' => 'สถานะการขอซื้อ',
                                  'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                  'attribute' => 'PRStatus',
                                  'hAlign' => GridView::ALIGN_CENTER,
                                  'value' => function ($model) {
                                  if ($model->PRStatus == null) {
                                  return '-';
                                  } else {
                                  return $model->PRStatus;
                                  }
                                  }
                                  ], */
                                    [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'noWrap' => true,
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{update}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-primary btn-xs"> Select </span>', $url, [
                                                        'title' => 'Select',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        //Update
                                        if ($action === 'update') {
                                            return Url::to(['create', 'prid' => $model['PRID'], 'prnum' => $model['PRNum']]);
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

