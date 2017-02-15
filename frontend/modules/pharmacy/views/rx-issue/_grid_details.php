<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\icons\Icon;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>

<style type="text/css">
    table.kv-grid-table thead tr th{
        background-color: white;
    }
</style>


<?php Pjax::begin(['id' => 'cpoedetail-pjax']); ?>
<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'layout' => $layout,
    'showPageSummary' => true,
    'striped' => false,
    'condensed' => true,
    'hover' => true,
    'bordered' => true,
    'headerRowOptions' => [
        'class' => GridView::TYPE_DEFAULT
    ],
    'export' => false,
    'toggleData' => false,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details ',
        //. Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']) . '</h3>',
        'type' => GridView::TYPE_DEFAULT,
        'before' => false,
        'after' => false,
    ],
    'toolbar' => [
            [
            'content' => Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']),
        ],
    ],
    'rowOptions' => function($model) {
        if (($model['cpoe_checkby'] != null) && (Yii::$app->controller->action->id == 'check')) {
            return ['class' => 'success'];
        }elseif (($model['cpoe_issueby'] != null) && (Yii::$app->controller->action->id == 'issue')) {
            return ['class' => 'success'];
        }
    },
    'columns' => [
            [
            'header' => 'ลำดับ',
            'attribute' => 'cpoe_seq',
            'contentOptions' => ['class' => 'text-center',],
            'headerOptions' => ['style' => 'color:black; text-align:center;'],
            'value' => function($model, $key, $index) {
                return $model->cpoe_seq;
            },
        ],
            [
            'header' => 'ประเภท',
            'attribute' => 'cpoe_Itemtype',
            'contentOptions' => ['style' => 'height:46px;text-align:center;font-size: 13pt;vertical-align: middle;background-color: #f5f5f5;color: #53a93f;',],
            'headerOptions' => ['style' => 'color:black;'],
            'value' => function($model, $key, $index) {
                return $model->cpoe_Itemtype == '51' || $model->cpoe_Itemtype == '52' ? '' : $model->cpoe_itemtype_decs;
            },
            'hAlign' => 'center',
            'noWrap' => true,
            'group' => true, // enable grouping,
        //'groupedRow' => true, // move grouped column to a single grouped row
//            'groupOddCssClass' => 'default', // configure odd group cell css class
//            'groupEvenCssClass' => 'default', // configure even group cell css class
        ],
            [
            'header' => 'cpoe_parentid',
            'attribute' => 'cpoe_parentid',
            'contentOptions' => ['class' => 'text-left'],
            'hidden' => true,
            'headerOptions' => ['style' => 'color:black;'],
            'value' => function($model, $key, $index) {
                return empty($model->cpoe_parentid) ? '' : $model->cpoe_parentid;
            },
            'group' => true, // enable grouping
            'subGroupOf' => 1 // supplier column index is the parent group
        ],
            [
            'header' => 'รหัสสินค้า',
            'attribute' => 'ItemID',
            'contentOptions' => ['class' => 'text-center',],
            'headerOptions' => ['style' => 'color:black; text-align:center;'],
            'value' => function($model, $key, $index) {
                return empty($model->ItemID) ? '' : $model->ItemID;
            },
        ],
            [
            'header' => 'รายการ',
            'attribute' => 'ItemDetail',
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'value' => function($model, $key, $index) {
                return empty($model->ItemDetail) ? '' : $model->ItemDetail;
            },
        ],
            [
            'header' => 'จำนวน',
            'attribute' => 'ItemQty1',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'noWrap' => true,
            'value' => function($model, $key, $index) {
                return empty($model->ItemQty1) ? '' : $model->ItemQty1;
            },
        ],
            [
            'header' => 'ราคา/หน่วย',
            'attribute' => 'ItemPrice',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'pageSummary' => 'รวม',
            'format' => ['decimal', 2],
            'noWrap' => true,
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'value' => function($model, $key, $index) {
                return empty($model->ItemPrice) ? '' : $model->ItemPrice;
            },
        ],
            [
            'header' => 'จำนวนเงิน',
            'attribute' => 'Item_Amt',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'format' => ['decimal', 2],
            'pageSummary' => true,
            'noWrap' => true,
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'value' => function($model, $key, $index) {
                return empty($model->Item_Amt) ? '' : $model->Item_Amt;
            },
        ],
            [
            'header' => 'เบิกได้',
            'attribute' => 'Item_Cr_Amt_Sum',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'pageSummary' => true,
            'noWrap' => true,
            'format' => ['decimal', 2],
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'value' => function($model, $key, $index) {
                return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
            },
        ],
            [
            'header' => 'เบิกไม่ได้',
            'attribute' => 'Item_Pay_Amt_Sum',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'pageSummary' => true,
            'noWrap' => true,
            'format' => ['decimal', 2],
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'value' => function($model, $key, $index) {
                return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
            },
        ],
            [
            'header' => 'Remark',
            'attribute' => 'cpoe_adj_note',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'format' => 'html',
            'value' => function($model, $key, $index) {
                return $model->cpoe_adj_note != 'OK' ? empty($model->cpoe_adj_note) ? '-' : $model->cpoe_adj_note : '<div class="success">' . Icon::show('ok', [], Icon::BSG) . '</div>';
            },
        ],
            [
            'class' => '\kartik\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
            'template' => '{ok} {request}',
            'noWrap' => true,
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'header' => Yii::$app->controller->action->id == 'verify' ? Html::button('OK All', ['class' => 'btn btn-xs btn-success activity-ok-all']) : 'Actions',
            'buttons' => [
                'ok' => function ($url, $model, $key) {
                    if (Yii::$app->controller->action->id == 'verify') {
                        if ($model['cpoe_adj_note'] != 'OK') {
                            return Html::button('OK', [
                                        'title' => 'OK',
                                        'class' => 'btn btn-success btn-xs activity-ok',
                            ]);
                        } else {
                            return Html::button('Cancel', [
                                        'title' => 'Cancel',
                                        'class' => 'btn btn-warning btn-xs activity-cancel',
                            ]);
                        }
                    }
                },
                'request' => function ($url, $model, $key) {
                    if ($model['cpoe_adj_note'] == 'OK' && $model['cpoe_adj_request'] != 'Y') {
                        return Html::button('Adjust Request', [
                                    'title' => 'Adjust Request',
                                    'class' => 'btn btn-info btn-xs activity-adjrequrst'
                        ]);
                    } else if ($model['cpoe_adj_request'] == 'Y') {
                        return Html::a('Edit Adjust Request', 'javascript:void(0);', [
                                    'title' => 'Edit Adjust Request',
                                    'class' => 'btn btn-warning btn-xs',
                                    'onclick' => 'EditAdjust(this);',
                                    'note' => $model['cpoe_adj_note'],
                                    'id' => $model['cpoe_ids'],
                        ]);
                    } else {
                        return Html::button('Adjust Request', [
                                    'title' => 'Adjust Request',
                                    'class' => 'btn btn-info btn-xs activity-adjrequrst'
                        ]);
                    }
                },
            ],
        ],
    ],
]);
?>
<?php Pjax::end(); ?>