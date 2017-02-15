<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;


$script = <<< JS
$(document).ready(function () {
        $('li.TabA').addClass("active");
    });
JS;
$this->registerJs($script);

$this->title = 'INVENTORY STATUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.tb1 tr td{
        text-align: center;
        background-color: white;
        height: 50px;
    }
    table.kv-grid-table thead tr th{
        background-color: white;
    }
</style>
<div class="row">
    <?php echo $this->render('_header_new') ?>

    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_new') ?>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?php Pjax::begin() ?>
                            <?php echo $this->render('_search_details', ['model' => $searchModel,'action' => 'index']); ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'responsive' => true,
                                'hover' => true,
                                'layout' => $layout,
                                'pjax' => true,
                                'striped' => false,
                                'export' => [
                                    'fontAwesome' => true,
                                    //'label' => '<b>Reports</b>',
                                    'class' => 'btn btn-default',
                                    'icon' => 'print',
                                    'showConfirmAlert' => FALSE,
                                    'header' => '',
                                    'stream' => false,
                                    'target' => '_blank',
                                    'showColumnSelector' => true
                                ],
                                'exportConfig' => [
                                    GridView::EXCEL => ['label' => 'EXCEL'],
                                    GridView::PDF => [
                                        'label' => Yii::t('app', 'PDF'),
                                        'iconOptions' => ['class' => 'text-danger'],
                                        'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                                        'mime' => 'application/pdf',
                                        'showHeader' => true,
                                        'showPageSummary' => true,
                                        'showFooter' => true,
                                        'showCaption' => true,
                                        'config' => [
                                            'mode' => 'UTF-8',
                                            'format' => 'A4-L',
                                            'destination' => 'D',
                                            'methods' => [
                                                'SetHeader' => ['InventoryStatus'],
                                                'SetFooter' => ['{PAGENO}'],
                                            ],
                                            'options' => [
                                                'title' => 'Report',
                                                'defaultheaderline' => 0,
                                                'defaultfooterline' => 0,
                                            ],
                                        ]
                                    ],
                                ],
                                'columns' => [
                                    [
                                        'class' => '\kartik\grid\SerialColumn'
                                    ],
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'value' => function ($model, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;'],
                                        'expandOneOnly' => true,
                                        'detailAnimationDuration' => 'slow', //fast
                                        'detailRowCssClass' => GridView::TYPE_SUCCESS,
                                        'detailUrl' => Url::to(['ext-pen']),
                                    ],
                                    [
                                        'header' => 'รหัสสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                }
                                    ],
                                    [
                                        'header' => 'รายละเอียดสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemName',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                    return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                }
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'DispUnit',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                }
                                    ],
                                    [
                                        'header' => 'คงคลัง',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                        'attribute' => 'ItemQtyBalance',
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                    return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                                }
                                    ],
                                    [
                                        'header' => 'Reorder Point',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                        'attribute' => 'Reorderpoint',
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'options' => ['style' => 'background-color: #d9edf7'],
                                        'value' => function ($model) {
                                    return empty($model['Reorderpoint']) ? '' : $model['Reorderpoint'];
                                }
                                    ],
                                    [
                                        'header' => 'ส่วนต่าง Rxorder Point',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                        'attribute' => 'ItemROPDiff',
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'options' => ['style' => 'background-color: #d9edf7'],
                                        'value' => function ($model) {
                                    return empty($model['ItemROPDiff']) ? '-' : $model['ItemROPDiff'];
                                }
                                    ],
                                    [
                                        'header' => 'ระดับการจัดเก็บ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                        'attribute' => 'ItemTargetLevel',
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'options' => ['style' => 'background-color: #fcf8e3'],
                                        'value' => function ($model) {
                                    return empty($model['ItemTargetLevel']) ? '-' : $model['ItemTargetLevel'];
                                }
                                    ],
                                    [
                                        'header' => 'ส่วนต่างระดับการจัดเก็บ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                        'attribute' => 'target_stk_diff',
                                        'options' => ['style' => 'background-color: #fcf8e3'],
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                    return empty($model['target_stk_diff']) ? '' : $model['target_stk_diff'];
                                }
                                    ],
                                    [
                                        'header' => 'กำลังขอซื้อ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #dff0d8'],
                                        'attribute' => 'pr_wip',
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'options' => ['style' => 'background-color: #dff0d8'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                    return empty($model['pr_wip']) ? '' : $model['pr_wip'];
                                }
                                    ],
                                    [
                                        'header' => 'รอส่งมอบ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #FF8F32'],
                                        'attribute' => 'po_wip',
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'options' => ['style' => 'background-color: #FF8F32'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                    return empty($model['po_wip']) ? '' : $model['po_wip'];
                                }
                                    ],
                                ]
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: right;">
                        <p></p>
                        
                        <p>
                            <?= Html::a('Close',['/'],['class' => 'btn btn-default']);?>
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>