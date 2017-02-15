<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\dropdown\DropdownX;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$Button = Html::beginTag('div', ['class' => 'dropdown']) .
        Html::button(Icon::show('plus', [], Icon::BSG) . '<span class="caret"></span></button>', ['type' => 'button', 'class' => 'btn btn-default dropdown-toggle', 'data-toggle' => 'dropdown','data-hover' => 'dropdown','data-delay' => 100]) .
        DropdownX::widget([
            'options'=>['class'=>'dropdown-success'], 
            'items' => [
                    ['label' => 'เปิดเส้น', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'Keep Vein Open', 'onclick' => 'CreateByType(this);', 'item-type' => '21','style' => 'font-size:11pt;']],
                    ['label' => 'Premed', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22','style' => 'font-size:11pt;']],
                    ['label' => 'Premed IV', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22','style' => 'font-size:11pt;']],
                    ['label' => 'Chemo IV', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22','style' => 'font-size:11pt;']],
                    ['label' => 'Injection', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'Chemo Injection', 'onclick' => 'CreateByType(this);', 'item-type' => '53','style' => 'font-size:11pt;']],
                    ['label' => 'Homemed', 'url' => 'javascript:void(0);', 'linkOptions' => ['class' => 'autosave btn-grid', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10','style' => 'font-size:11pt;']],
                '<li class="divider"></li>',
                    ['label' => 'Sort', 'url' => ['sort', 'data' => $model['cpoe_id']], 'linkOptions' => ['role' => 'modal-remote','style' => 'font-size:11pt;']],
            ],
        ]) .
        Html::endTag('div');
$action = Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed', false, ['class' => 'btn btn-success btn-sm autosave btn-grid', 'title-modal' => 'Keep Vein Open', 'onclick' => 'CreateByType(this);', 'item-type' => '21','style' => 'font-size:11pt;'])
?>
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
        'type' => GridView::TYPE_PRIMARY,
        'before' =>
        $Button,
        'after' => false,
    ],
//    'toolbar' => [
//            [
//            'content' => Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']),
//        ],
//    ],
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
            'class' => '\kartik\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
            'template' => '{print} {update} {delete}',
            'noWrap' => true,
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'header' => 'Actions',
            'buttons' => [
                'update' => function ($key, $model) {
                    if ($model['cpoe_Itemtype'] == 21) {
                        /* $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                          return Html::a('Edit', $url, [
                          'title' => 'Edit',
                          'class' => 'btn btn-info btn-xs',
                          'role' => 'modal-remote',
                          ]); */
                        return Html::a('Edit', false, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'onclick' => 'EditByType(this);',
                                    'title-modal' => 'Keep Vein Open',
                                    'ids' => $model['cpoe_ids'],
                                    'item-type' => $model['cpoe_Itemtype'],
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 22) {
                        return Html::a('Edit', false, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'onclick' => 'EditByType(this);',
                                    'title-modal' => 'Keep Vein Open',
                                    'ids' => $model['cpoe_ids'],
                                    'item-type' => $model['cpoe_Itemtype'],
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == '50' || $model['cpoe_Itemtype'] == '40') {
                        return Html::a('Edit', 'javascript:void(0);', [
                                    'title' => 'Edit',
                                    'onclick' => 'EditIVSolution(' . $model['cpoe_ids'] . ');',
                                    'class' => 'btn btn-info btn-xs'
                        ]);
                    } else if ($model['cpoe_Itemtype'] == '53') {
                        return Html::a('Edit', false, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'onclick' => 'EditByType(this);',
                                    'title-modal' => 'Keep Vein Open',
                                    'ids' => $model['cpoe_ids'],
                                    'item-type' => $model['cpoe_Itemtype'],
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 54) {
                        $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    } else if ($model['cpoe_Itemtype'] == 10 || $model['cpoe_Itemtype'] == 20) {
                        $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }
                },
                'print' => function ($url, $model) {
                    if ($model['cpoe_Itemtype'] == 51 || $model['cpoe_Itemtype'] == 52) {
                        return '';
                    } else {
                        return Html::a('Print', '#', [
                                    'title' => 'Print',
                                    'data-toggle' => 'modal',
                                    'class' => 'btn btn-default btn-xs btn-printlabel'
                        ]);
                    }
                },
                'delete' => function ($url, $model) {
                    if ($model['cpoe_Itemtype'] == 51 || $model['cpoe_Itemtype'] == 52) {
                        return '';
                    } else {
                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                    'title' => 'Delete',
                                    'data-toggle' => 'modal',
                                    'class' => 'activity-delete-link',
                        ]);
                    }
                },
            ],
        ],
    ],
]);
?>

<?php Pjax::end(); ?>
<?php ?>