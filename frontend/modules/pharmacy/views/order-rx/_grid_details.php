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
if ($model['cpoe_type'] == '1012') {
    $Button = Html::a(Icon::show('plus', [], Icon::BSG) . 'เปิดเส้น', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'เปิดเส้น', 'onclick' => 'CreateByType(this);', 'item-type' => '21', 'style' => 'font-size:11pt;', 'seq' => '']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed', false, ['class' => 'btn btn-info autosave btn-grid', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22', 'style' => 'font-size:11pt;', 'seq' => '']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-info autosave btn-grid', 'title-modal' => 'Premed IV Solution', 'onclick' => 'CreateIVSolution(this);', 'item-type' => '40', 'cpoe_id' => $model['cpoe_id'], 'style' => 'font-size:11pt;', 'seq' => '']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple autosave btn-grid', 'title-modal' => 'Chemo IV Solution', 'onclick' => 'CreateIVSolution(this);', 'item-type' => '50', 'cpoe_id' => $model['cpoe_id'], 'style' => 'font-size:11pt;', 'seq' => '']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Injection', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'Chemo Injection', 'onclick' => 'CreateByType(this);', 'item-type' => '53', 'style' => 'font-size:11pt;', 'seq' => '']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Homemed', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10', 'style' => 'font-size:11pt;', 'seq' => '']);
} elseif ($model['cpoe_type'] == '1011') {
    $Button = Html::a('<i class="glyphicon glyphicon-plus"></i>Homemed', false, ['class' => 'btn btn-success btn-sm autosave', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10', 'style' => 'font-size:11pt;', 'seq' => '']);
}
/*
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
 * 
 */
?>
<?php Pjax::begin(['id' => 'cpoedetails-pjax']); ?>
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
    'pjax' => true,
    'headerRowOptions' => [
        'class' => GridView::TYPE_DEFAULT
    ],
    'export' => false,
    'toggleData' => false,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> รายละเอียด ',
        //. Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']) . '</h3>',
        'type' => GridView::TYPE_SUCCESS,
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
            'headerOptions' => ['style' => 'color:black; text-align:center;font-size:12pt;'],
            'value' => function($model, $key, $index) {
                return $model['cpoe_seq'];
            },
            //'group' => true,
        ],
        [
            'header' => 'ประเภท',
            'attribute' => 'cpoe_seq',
            'contentOptions' => ['style' => 'height:46px;text-align:left;font-size: 13pt;vertical-align: middle;background-color: #f5f5f5;color: #53a93f;',],
            'headerOptions' => ['style' => 'color:black;font-size:12pt;'],
            'value' => function($model, $key, $index) {
                if (($model->cpoe_Itemtype == '41') || ($model->cpoe_Itemtype == '42') || ($model->cpoe_Itemtype == '51') || ($model->cpoe_Itemtype == '52')) {
                    return false;
                } elseif (($model->cpoe_Itemtype == '40') || ($model->cpoe_Itemtype == '50')) {
                    return 'seq '.$model->cpoe_seq.' '.$model['cpoe_itemtype_decs'];
                } else if ($model->cpoe_Itemtype == '21') {
                    return 'seq '.$model->cpoe_seq . ' ' . Html::a($model['cpoe_itemtype_decs'].' '.Icon::show('plus', [], Icon::BSG), false, ['class' => 'btn btn-sm btn-success', 'title-modal' => 'เปิดเส้น', 'onclick' => 'CreateByType(this);', 'item-type' => '21', 'seq' => $model->cpoe_seq]);
                } else if ($model->cpoe_Itemtype == '22') {
                    return 'seq '.$model->cpoe_seq . ' ' . Html::a($model['cpoe_itemtype_decs'].' '.Icon::show('plus', [], Icon::BSG), false, ['class' => 'btn btn-sm btn-success', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22', 'seq' => $model->cpoe_seq]);
                } else if ($model->cpoe_Itemtype == '53') {
                    return 'seq '.$model->cpoe_seq . ' ' . Html::a($model['cpoe_itemtype_decs'].' '.Icon::show('plus', [], Icon::BSG), false, ['class' => 'btn btn-sm btn-success', 'title-modal' => 'Chemo Injection', 'onclick' => 'CreateByType(this);', 'item-type' => '53', 'seq' => $model->cpoe_seq]);
                } else if ($model->cpoe_Itemtype == '10') {
                    return 'seq '.$model->cpoe_seq . ' ' . Html::a($model['cpoe_itemtype_decs'].' '.Icon::show('plus', [], Icon::BSG), false, ['class' => 'btn btn-sm btn-success', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10', 'seq' => $model->cpoe_seq]);
                }
                //return $model->cpoe_Itemtype == '41' || $model->cpoe_Itemtype == '42' || $model->cpoe_Itemtype == '51' || $model->cpoe_Itemtype == '52' ? '-' : $model->cpoe_itemtype_decs.' '.Html::a(Icon::show('plus', [], Icon::BSG),['add-seq','seq' => $model->cpoe_seq],['class' => 'btn btn-sm btn-success']);
            },
            'hAlign' => 'center',
            'format' => 'raw',
            'noWrap' => true,
            'group' => true, // enable grouping,
            'groupedRow' => true, // move grouped column to a single grouped row
            'groupOddCssClass' => function($model, $key, $index) {
                return $model->cpoe_Itemtype == '41' || $model->cpoe_Itemtype == '42' || $model->cpoe_Itemtype == '51' || $model->cpoe_Itemtype == '52' ? 'kv-grid-hide' : 'kv-grouped-row';
            }, // configure odd group cell css class
            'groupEvenCssClass' => function($model, $key, $index) {
                return $model->cpoe_Itemtype == '41' || $model->cpoe_Itemtype == '42' || $model->cpoe_Itemtype == '51' || $model->cpoe_Itemtype == '52' ? 'kv-grid-hide' : 'kv-grouped-row';
            }, // configure even group cell css class
        ],
        [
            'header' => 'cpoe_parentid',
            'attribute' => 'cpoe_parentid',
            'contentOptions' => ['class' => 'text-left'],
            'hidden' => true,
            'headerOptions' => ['style' => 'color:black;font-size:12pt;'],
            'value' => function($model, $key, $index) {
                return empty($model->cpoe_parentid) ? '' : $model->cpoe_parentid;
            },
            //'group' => true, // enable grouping
//            'subGroupOf' => 1 // supplier column index is the parent group
        ],
        [
            'header' => 'รหัสสินค้า',
            'attribute' => 'ItemID',
            'contentOptions' => [
                'class' => 'text-center',
            ],
            'headerOptions' => ['style' => 'color:black; text-align:center;font-size:12pt;'],
            'value' => function($model, $key, $index) {
                return empty($model->ItemID) ? '' : $model->ItemID;
            },
        ],
        [
            'header' => 'รายการ',
            'attribute' => 'ItemDetail',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
            'value' => function($model, $key, $index) {
                return empty($model->ItemDetail) ? '' : $model->ItemDetail.'<p> - '.$model['sig_decs'].'</p>';
            },
        ],
        [
            'header' => 'จำนวน',
            'attribute' => 'ItemQty1',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
            'noWrap' => true,
            'value' => function($model, $key, $index) {
                return empty($model->ItemQty1) ? '' : $model->ItemQty1;
            },
        ],
        [
            'header' => 'ราคา/หน่วย',
            'attribute' => 'ItemPrice',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
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
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
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
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
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
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;'],
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
            'headerOptions' => ['style' => 'color:black;text-align:center;font-size:12pt;',],
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
                                    'title-modal' => 'เปิดเส้น',
                                    'ids' => $model['cpoe_ids'],
                                    'item-type' => $model['cpoe_Itemtype'],
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 22) {
                        return Html::a('Edit', false, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'onclick' => 'EditByType(this);',
                                    'title-modal' => 'Premedication',
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
                                    'title-modal' => 'Chemo Injection',
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
                        return Html::a('Edit', false, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'onclick' => 'EditByType(this);',
                                    'ids' => $model['cpoe_ids'],
                                    'item-type' => $model['cpoe_Itemtype'],
                                    'title-modal' => 'Homemed',
                        ]);
                    }
                },
                'print' => function ($url, $model) {
                    if ($model['cpoe_Itemtype'] == 41 || $model['cpoe_Itemtype'] == 42 || $model['cpoe_Itemtype'] == 51 || $model['cpoe_Itemtype'] == 52) {
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
                    if ($model['cpoe_Itemtype'] == 41 || $model['cpoe_Itemtype'] == 42 || $model['cpoe_Itemtype'] == 51 || $model['cpoe_Itemtype'] == 52) {
                        return '';
                    } else {
                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', false, [
                                    'title' => 'Delete',
                                    'class' => 'activity-delete-link',
                                    'onclick' => 'DeleteDetails('.$model['cpoe_ids'].','.$model['cpoe_id'].');',
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