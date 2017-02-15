<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$this->title = 'ใบสั่งซื้อรอการทวนสอบ';
$this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['detail-verify']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/Purchasing/views/dashboard/_hd_pharmacy.php'); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/Purchasing/views/dashboard/_tab_pharmacy.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                                         <?php echo $this->render('_search', ['model' => $searchModel, 'action' => 'detail-verify']); ?>
                                        <p></p>
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
                                                    'headerOptions' => ['class' => 'kartik-sheet-style','style' => 'color:black;']
                                                ],
                                                [
                                                    'header' => 'เลขที่ใบสั่งซื้อ',
                                                    'attribute' => 'PONum',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'วันที่',
                                                    'attribute' => 'PODate',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'ประเภทใบขอซื้อ',
                                                    'attribute' => 'PRTypeID',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'value' => 'prtype.PRType',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'ประเภทการสั่งซื้อ',
                                                    'attribute' => 'POTypeID',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'value' => 'potype.POType',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'กำหนดการส่งมอบ',
                                                    'attribute' => 'PODueDate',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'สถานะใบสั่งซื้อ',
                                                    'attribute' => 'POStatus',
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'value' => 'postatus.POStatusDes',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'noWrap' => true,
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                                    'template' => '{view}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'buttons' => [
                                                        //view button
                                                        'view' => function ($url, $model) {
                                                            return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
                                                                        'title' => Yii::t('app', 'Verify'),
                                                                        'data-pjax' => 0,
                                                            ]);
                                                        },
                                                            ],
                                                            'urlCreator' => function ($action, $model, $key, $index) {
                                                        if ($action === 'view') {
                                                            return Url::to(['update-detail-verify', 'id' => $key, 'view' => 'false']);
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
                            </div>
                        </div>
                    </div>
                </div>
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

