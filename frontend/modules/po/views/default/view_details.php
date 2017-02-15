<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$layout = <<< HTML
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$headerOption = ['style' => 'text-align:center;color:black;background-color: #ffffff'];
?>
<style type="text/css">
    table.kv-grid-table th{
        white-space: nowrap;
    }
    table#datatable-tpu thead tr th{
        border-top: 1px solid #ddd;
        text-align: center;
        white-space: nowrap;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php if ($modelPR['PRTypeID'] == 1) : ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'hover' => true,
                //'bordered' => false,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => false,
                'layout' => $layout,
                'emptyCell' => '-',
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'rowOptions' => function($model) {
                    if ($model->PRItemOnPCPlan != 8) {
                        return ['class' => 'warning'];
                    }
                },
                'panel' => [
                    'heading' => '<h3 class="panel-title">รายละเอียดรายการขอซื้อ</h3>',
                    'type' => GridView::TYPE_SUCCESS,
                    'before' => false,
                    'after' => false,
                    'footer' => false
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '9'],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'headerOptions' => $headerOption,
                        'expandOneOnly' => true,
                        'detailAnimationDuration' => 'slow', //fast
                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                        'detailUrl' => Url::to(['/pr/gpu/item-details-verify']),
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'TMTID_GPU',
                        'header' => Html::encode('รหัสยาสามัญ'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<span class="badge badge-success"><strong>' . $model->TMTID_GPU . '</strong></span>';
                        },
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => Html::encode('รายละเอียดยาสามัญ'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->ItemName . ' ' . $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 3],
                        'header' => Html::encode('ขอซื้อ'),
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('ทวนสอบ'),
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'noWrap' => true,
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->getUnit() == null ? '-' : $model->getUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyQty',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'VerifyUnit',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'noWrap' => true,
                        'value' => function ($model) {
                            return $model->getVerifyUnit() == null ? '-' : $model->getVerifyUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyUnitCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 4);
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'noWrap' => true,
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '' : $model->PRExtendedCost;
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => false,
                        'headerOptions' => ['hidden' => true],
                        'noWrap' => true,
                        'pageSummary' => 'บาท',
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'template' => '',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [11, 12]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'จำนวน',
                                    8 => 'หน่วย',
                                    9 => 'ราคา/หน่วย',
                                    10 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff;'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    10 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    11 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                ],
                                // html attributes for group summary row
                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                            ];
                        }
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>
        <?php if ($modelPR['PRTypeID'] == 2) : ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'hover' => true,
                //'bordered' => false,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => false,
                'layout' => $layout,
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'rowOptions' => function($model) {
                    if ($model->PRItemOnPCPlan != 8) {
                        return ['class' => 'warning'];
                    }
                },
                'panel' => [
                    'heading' => '<h3 class="panel-title">รายละเอียดรายการขอซื้อ</h3>',
                    'type' => GridView::TYPE_SUCCESS,
                    'before' => false,
                    'after' => false,
                    'footer' => false
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '9'],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'headerOptions' => $headerOption,
                        'expandOneOnly' => true,
                        'detailAnimationDuration' => 'slow', //fast
                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                        'detailUrl' => Url::to(['/pr/tpu/item-details-verify']),
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'TMTID_TPU',
                        'header' => Html::encode('รหัสยาการค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<span class="badge badge-success"><strong>' . $model->TMTID_TPU . '</strong></span>';
                        },
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => Html::encode('รายละเอียดยา'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->ItemName . ' ' . $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 3],
                        'header' => Html::encode('ขอซื้อ'),
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('ทวนสอบ'),
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'noWrap' => true,
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->getUnit() == null ? '-' : $model->getUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyQty',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'VerifyUnit',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'noWrap' => true,
                        'value' => function ($model) {
                            return $model->getVerifyUnit() == null ? '-' : $model->getVerifyUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyUnitCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 4);
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'noWrap' => true,
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model['PRVerifyQty']) ? '' : $model['PRExtendedCost'];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => false,
                        'headerOptions' => ['hidden' => true],
                        'noWrap' => true,
                        'pageSummary' => 'บาท',
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'template' => '',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [11, 12]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'จำนวน',
                                    8 => 'หน่วย',
                                    9 => 'ราคา/หน่วย',
                                    10 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff;'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    10 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    11 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                ],
                                // html attributes for group summary row
                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                            ];
                        }
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>

        <?php if ($modelPR['PRTypeID'] == 3) : ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'hover' => true,
                //'bordered' => false,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => false,
                'layout' => $layout,
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'rowOptions' => function($model) {
                    if ($model->PRItemOnPCPlan != 8) {
                        return ['class' => 'warning'];
                    }
                },
                'panel' => [
                    'heading' => '<h3 class="panel-title">รายละเอียดรายการขอซื้อ</h3>',
                    'type' => GridView::TYPE_SUCCESS,
                    'before' => false,
                    'after' => false,
                    'footer' => false
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '9'],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'headerOptions' => $headerOption,
                        'expandOneOnly' => true,
                        'detailAnimationDuration' => 'slow', //fast
                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                        'detailUrl' => Url::to(['/pr/nd/item-details-verify']),
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemID',
                        'header' => Html::encode('รหัสสินค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<span class="badge badge-success"><strong>' . $model->ItemID . '</strong></span>';
                        },
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => Html::encode('รายละเอียดสินค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->ItemName . ' ' . $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 3],
                        'header' => Html::encode('ขอซื้อ'),
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('ทวนสอบ'),
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'noWrap' => true,
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->getUnit() == null ? '-' : $model->getUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyQty',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'VerifyUnit',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'noWrap' => true,
                        'value' => function ($model) {
                            return $model->getVerifyUnit() == null ? '-' : $model->getVerifyUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyUnitCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 4);
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'noWrap' => true,
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model['PRVerifyQty']) ? '' : $model['PRExtendedCost'];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => false,
                        'headerOptions' => ['hidden' => true],
                        'noWrap' => true,
                        'pageSummary' => 'บาท',
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'template' => '',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [11, 12]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'จำนวน',
                                    8 => 'หน่วย',
                                    9 => 'ราคา/หน่วย',
                                    10 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff;'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    10 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    11 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                ],
                                // html attributes for group summary row
                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                            ];
                        }
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>

        <?php if ($modelPR['PRTypeID'] == 4) : ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'hover' => true,
                //'bordered' => false,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => false,
                'layout' => $layout,
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'rowOptions' => function($model) {
                    if ($model->PRItemOnPCPlan != 8) {
                        return ['class' => 'warning'];
                    }
                },
                'panel' => [
                    'heading' => '<h3 class="panel-title">รายละเอียดรายการขอซื้อ</h3>',
                    'type' => GridView::TYPE_SUCCESS,
                    'before' => false,
                    'after' => false,
                    'footer' => false
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '9'],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'headerOptions' => $headerOption,
                        'expandOneOnly' => true,
                        'detailAnimationDuration' => 'slow', //fast
                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                        'detailUrl' => Url::to(['/pr/tpu-cont/item-details-verify']),
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemID',
                        'header' => Html::encode('รหัสสินค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<span class="badge badge-success"><strong>' . $model->ItemID . '</strong></span>';
                        },
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => Html::encode('รายละเอียดยา'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->ItemName . ' ' . $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 3],
                        'header' => Html::encode('ขอซื้อ'),
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('ทวนสอบ'),
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'noWrap' => true,
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->getUnit() == null ? '-' : $model->getUnit();
                            
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyQty',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'VerifyUnit',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'noWrap' => true,
                        'value' => function ($model) {
                            return $model->getVerifyUnit() == null ? '-' : $model->getVerifyUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyUnitCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 4);
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'noWrap' => true,
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model['PRVerifyQty']) ? '' : $model['PRExtendedCost'];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => false,
                        'headerOptions' => ['hidden' => true],
                        'noWrap' => true,
                        'pageSummary' => 'บาท',
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'template' => '',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [11, 12]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'จำนวน',
                                    8 => 'หน่วย',
                                    9 => 'ราคา/หน่วย',
                                    10 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff;'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    10 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    11 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                ],
                                // html attributes for group summary row
                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                            ];
                        }
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>

        <?php if ($modelPR['PRTypeID'] == 5) : ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
                'hover' => true,
                //'bordered' => false,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => false,
                'layout' => $layout,
                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'rowOptions' => function($model) {
                    if ($model->PRItemOnPCPlan != 8) {
                        return ['class' => 'warning'];
                    }
                },
                'panel' => [
                    'heading' => '<h3 class="panel-title">รายละเอียดรายการขอซื้อ</h3>',
                    'type' => GridView::TYPE_SUCCESS,
                    'before' => false,
                    'after' => false,
                    'footer' => false
                ],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '9'],
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'headerOptions' => $headerOption,
                        'expandOneOnly' => true,
                        'detailAnimationDuration' => 'slow', //fast
                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                        'detailUrl' => Url::to(['/pr/nd-cont/item-details-verify']),
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemID',
                        'header' => Html::encode('รหัสสินค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function ($model) {
                            return '<span class="badge badge-success"><strong>' . $model->ItemID . '</strong></span>';
                        },
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => Html::encode('รายละเอียดสินค้า'),
                        'headerOptions' => $headerOption,
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->ItemName . ' ' . $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 3],
                        'header' => Html::encode('ขอซื้อ'),
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('ทวนสอบ'),
                        'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'noWrap' => true,
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->getUnit() == null ? '-' : $model->getUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyQty',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'VerifyUnit',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'noWrap' => true,
                        'value' => function ($model) {
                            return $model->getVerifyUnit() == null ? '-' : $model->getVerifyUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRVerifyUnitCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 4);
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'noWrap' => true,
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return empty($model['PRVerifyQty']) ? '' : $model['PRExtendedCost'];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => false,
                        'headerOptions' => ['hidden' => true],
                        'noWrap' => true,
                        'pageSummary' => 'บาท',
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'template' => '',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [11, 12]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'จำนวน',
                                    8 => 'หน่วย',
                                    9 => 'ราคา/หน่วย',
                                    10 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff;'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    10 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                    11 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap'],
                                ],
                                // html attributes for group summary row
                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                            ];
                        }
                    ],
                ],
            ]);
            ?>
        <?php endif; ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider1,
            'showPageSummary' => true,
            'hover' => false,
            //'bordered' => false,
            'pjax' => true,
            'striped' => false,
            'condensed' => true,
            'toggleData' => false,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
            'layout' => $layout,
            'panel' => [
                'heading' => '<h3 class="panel-title">รายละเอียดใบสั่งซื้อ</h3>',
                'type' => GridView::TYPE_SUCCESS,
                'before' => false,
                'after' => false,
                'footer' => false
            ],
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '#',
                    'headerOptions' => $headerOption,
                    'pageSummaryOptions' => ['colspan' => '9', 'style' => 'background-color: #f5f5f5'],
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'headerOptions' => $headerOption,
                    'expandOneOnly' => true,
                    'detailAnimationDuration' => 'slow', //fast
                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                    'detailUrl' => Url::to(['item-details-verify']),
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'ItemID',
                    'header' => ($modelPR['PRTypeID'] == '3') || ($modelPR['PRTypeID'] == '5') || ($modelPR['PRTypeID'] == '8') ? 'รหัสสินค้า' : 'รหัสสินค้า/รหัสยาสามัญ',
                    'headerOptions' => $headerOption,
                    'format' => 'html',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        if ((empty($model['TMTID_GPU'])) || ($model['TMTID_GPU'] == null)) {
                            return '<span class="badge badge-success"><strong>' . $model['ItemID'] . '</strong></span>';
                        } elseif ((empty($model['ItemID'])) || ($model['ItemID'] == null)) {
                            return '<span class="badge badge-success"><strong>-</strong></span>' . ' ' . '<span class="badge badge-primary"><strong>' . $model['TMTID_GPU'] . '</strong></span>';
                        } else {
                            return '<span class="badge badge-success"><strong>' . $model['ItemID'] . '</strong></span>' . ' ' . '<span class="badge badge-primary"><strong>' . $model['TMTID_GPU'] . '</strong></span>';
                        }
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'ItemName',
                    'header' => 'รายละเอียดสินค้า',
                    'headerOptions' => $headerOption,
                    'value' => function ($model) {
                        return empty($model['ItemName']) ? '-' : $model['ItemName'];
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRApprovedOrderQty',
                    'header' => 'ขอซื้อ', #จำนวน
                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #f5f5f5;', 'colspan' => 3],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return empty($model['PRApprovedOrderQty']) ? '-' : number_format($model['PRApprovedOrderQty'], 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRApprovedUnitCost',
                    'header' => Html::encode('สั่งซื้อ'),
                    'headerOptions' => ['style' => 'color:black;background-color: #f5f5f5;text-align:center', 'colspan' => 4],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return empty($model['PRApprovedUnitCost']) ? '-' : number_format($model['PRApprovedUnitCost'], 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRUnit',
                    //'header' => Html::encode('Actions'),
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'noWrap' => true,
                    'value' => function ($model) {
                        return empty($model->detail->PRUnit) ? '-' : $model->detail->PRUnit;
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POQty',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return empty($model->detail->POQty) ? '-' : number_format($model->detail->POQty, 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POUnitCost',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return empty($model->detail->POUnitCost) ? '-' : number_format($model->detail->POUnitCost, 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POUnit',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'pageSummary' => Yii::t('app', 'Total'),
                    'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5', 'noWrap' => true,],
                    'value' => function ($model) {
                        return empty($model->detail->POUnit) ? '-' : $model->detail->POUnit;
                    },
                ],
                [
                    'attribute' => 'POExtenedCost',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'pageSummary' => true,
                    'format' => ['decimal', 4],
                    'value' => function ($model) {
                        return empty($model->detail->POExtenedCost) ? '' : $model->detail->POExtenedCost;
                    },
                    'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'noWrap' => true,
                    'hAlign' => GridView::ALIGN_CENTER,
                    'headerOptions' => ['hidden' => true],
                    'template' => '',
                    'pageSummary' => 'บาท',
                    'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
                    'buttons' => [
                    ],
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'width' => '10px',
                    'hidden' => true,
                    'group' => true, // enable grouping
                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                        return [
                            'mergeColumns' => [
                                [0, 3],
                                [11, 12]
                            ], // columns to merge in summary
                            'content' => [// content to show in each summary cell
                                1 => '',
                                4 => 'จำนวน',
                                5 => 'ราคา/หน่วย',
                                6 => 'หน่วย',
                                7 => 'จำนวน',
                                8 => 'ราคา/หน่วย',
                                9 => 'หน่วย',
                                10 => 'ราคารวม',
                            ],
                            'contentOptions' => [// content html attributes for each summary cell
                                0 => ['style' => 'background-color: #ffffff;color:black'],
                                1 => ['style' => 'font-variant:small-caps;background-color: #f5f5f5;color:black'],
                                4 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                5 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                6 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                7 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                8 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                9 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                10 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                11 => ['style' => 'background-color: #ffffff;color:black'],
                            ],
                            // html attributes for group summary row
                            'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                        ];
                    }
                ],
            ],
        ]);
        ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider2,
            'showPageSummary' => true,
            'hover' => false,
            //'bordered' => false,
            'pjax' => true,
            'striped' => false,
            'condensed' => true,
            'toggleData' => false,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
            'layout' => $layout,
            'panel' => [
                'heading' => '<h3 class="panel-title">รายละเอียดรายการยาแถม</h3>',
                'type' => GridView::TYPE_SUCCESS,
                'before' => false,
                'after' => false,
                'footer' => false
            ],
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '36px',
                    'header' => '#',
                    'headerOptions' => $headerOption,
                    'pageSummaryOptions' => ['colspan' => '12', 'style' => 'background-color: #f5f5f5'],
                ],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'headerOptions' => $headerOption,
                    'expandOneOnly' => true,
                    'detailAnimationDuration' => 'slow', //fast
                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                    'detailUrl' => Url::to(['item-details-verify']),
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'ItemID',
                    'header' => 'รหัสสินค้า',
                    'headerOptions' => $headerOption,
                    'format' => 'html',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return '<span class="badge badge-success"><strong>' . $model['ItemID'] . '</strong></span>';
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'ItemName',
                    'header' => 'รายละเอียดสินค้า',
                    'headerOptions' => $headerOption,
                    'value' => function ($model) {
                        return empty($model['ItemName']) ? '-' : $model['ItemName'];
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRApprovedOrderQty',
                    'header' => 'ขอซื้อ', #จำนวน
                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #f5f5f5;', 'colspan' => 3],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return '-';
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRApprovedUnitCost',
                    'header' => Html::encode('สั่งซื้อ'),
                    'headerOptions' => ['style' => 'color:black;background-color: #f5f5f5;text-align:center', 'colspan' => 4],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return '-';
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'PRUnit',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'noWrap' => true,
                    'value' => function ($model) {
                        return '-';
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POQty',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return empty($model->detail->POQty) ? '-' : number_format($model->detail->POQty, 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POUnitCost',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return empty($model->detail->POUnitCost) ? '-' : number_format($model->detail->POUnitCost, 4);
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'attribute' => 'POUnit',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'pageSummaryOptions' => ['hidden' => true],
                    'value' => function ($model) {
                        return empty($model->detail->POUnit) ? '-' : $model->detail->POUnit;
                    },
                ],
                [
                    'attribute' => 'POExtenedCost',
                    'headerOptions' => ['hidden' => true],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'format' => ['decimal', 4],
                    'value' => function ($model) {
                        return empty($model->detail->POExtenedCost) ? '' : $model->detail->POExtenedCost;
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'width' => '10px',
                    'hidden' => true,
                    'group' => true, // enable grouping
                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                        return [
                            'mergeColumns' => [
                                [0, 3],
                                [10, 11]
                            ], // columns to merge in summary
                            'content' => [// content to show in each summary cell
                                1 => '',
                                4 => 'จำนวน',
                                5 => 'ราคา/หน่วย',
                                6 => 'หน่วย',
                                7 => 'จำนวน',
                                8 => 'ราคา/หน่วย',
                                9 => 'หน่วย',
                                10 => 'ราคารวม',
                            ],
                            'contentOptions' => [// content html attributes for each summary cell
                                0 => ['style' => 'background-color: #ffffff;color:black'],
                                1 => ['style' => 'font-variant:small-caps;background-color: #f5f5f5;color:black'],
                                4 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                5 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                6 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                7 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                8 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                9 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                                10 => ['style' => 'text-align:center;background-color: #f5f5f5;color:black;white-space: nowrap;'],
                            //11 => ['style' => 'background-color: #ffffff;color:black'],
                            ],
                            // html attributes for group summary row
                            'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                        ];
                    }
                ],
            ],
        ]);
        ?>

    </div>
</div>

