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

$this->title = 'ใบสั่งซื้อไม่ผ่านการอนุมัติ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_F').addClass("active");
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
                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                        <?php echo $this->render('_search', ['model' => $searchModel,'action' => 'list-reject-approve']); ?>
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
                                                        'title' => 'Verify',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view') {
                                            return Url::to(['update-detail-approve', 'id' => $key, 'view' => 'reject-approve']);
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

