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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
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
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> รายละเอียดรายการขอซื้อ</h3>',
                'type' => GridView::TYPE_DEFAULT,
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
                    'detailUrl' => Url::to(['item-details-verify']),
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
                        return $model->ItemName.' '. $model->getSatusOnplan($model['PRItemOnPCPlan']);
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
                    'attribute' => 'PRUnit',
                    'header' => Html::encode('ทวนสอบ'),
                    'headerOptions' => ['style' => 'color:black;background-color: #ffffff;text-align:center', 'colspan' => 4],
                    'noWrap' => true,
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return $model->getUnit() == null ? '-' : $model->getUnit();
                    },
                    'pageSummaryOptions' => ['hidden' => true],
                ],
                    [
                    'attribute' => 'PRUnitCost',
                    'header' => Html::encode('Actions'),
                    'headerOptions' => $headerOption,
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
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
                                5 => 'หน่วย',
                                6 => 'ราคา/หน่วย',
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
    </div>
</div>

