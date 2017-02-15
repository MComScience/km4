<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\icons\Icon;

$headerOption = ['style' => 'text-align:center;color:black;background-color: #f5f5f5'];
$action = Yii::$app->controller->action->id;

$layout = <<< HTML
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

if (($action == 'update') || ($action == 'reject')) {
    //ยาสามัญ
    if (($modelPR['PRTypeID'] == '1') || ($modelPR['PRTypeID'] == '6')) {
        $actioncolumn1 = [
            'class' => 'kartik\grid\ActionColumn',
            'noWrap' => true,
            'hAlign' => GridView::ALIGN_CENTER,
            'headerOptions' => ['hidden' => true],
            'template' => ' {select} {edit}',
            'pageSummary' => 'บาท',
            'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
            'buttons' => [
                'select' => function ($url, $model, $key) {
                    if (empty($model->POApprovedOrderQty)) {
                        return Html::a('Select', false, [
                                    'title' => 'Select',
                                    'class' => 'btn btn-success btn-xs',
                                    'gpu' => $model['TMTID_GPU'],
                                    'key' => $key,
                                    'onclick' => 'SelectItem(this);',
                        ]);
                    } else {
                        return Html::a('Change Item', false, [
                                    'title' => 'Select',
                                    'class' => 'btn btn-warning btn-xs',
                                    'gpu' => $model['TMTID_GPU'],
                                    'key' => $key,
                                    'onclick' => 'SelectItem(this);',
                        ]);
                    }
                },
                'edit' => function ($url, $model) {
                    if (empty($model->POApprovedOrderQty)) {
                        return Html::button(Icon::show('edit') . Yii::t('app', 'Edit'), ['class' => 'btn btn-primary btn-xs', 'disabled' => true]);
                    } else {
                        return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                                    'title' => Yii::t('app', 'Edit'),
                                    'class' => 'btn btn-primary btn-xs activity-update-type1',
                        ]);
                    }
                },
            ],
        ];
    } else {
        $actioncolumn1 = [
            'class' => 'kartik\grid\ActionColumn',
            'noWrap' => true,
            'hAlign' => GridView::ALIGN_CENTER,
            'headerOptions' => ['hidden' => true],
            'template' => '{edit}',
            'pageSummary' => 'บาท',
            'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
            'buttons' => [
                'edit' => function ($url, $model) {
                    return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                                'title' => Yii::t('app', 'Edit'),
                                'class' => 'btn btn-primary btn-xs activity-update-type1',
                    ]);
                },
            ],
        ];
    }
    //Type2
    $actioncolumn2 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {edit} {delete}',
        'pageSummaryOptions' => ['hidden' => true],
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'class' => 'btn btn-primary btn-xs activity-update-type2',
                            'title' => Yii::t('app', 'Edit'),
                            'data-toggle' => 'modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::button(Icon::show('trash-o') . Yii::t('app', 'Delete'), [
                            'title' => Yii::t('app', 'Delete'),
                            'data-toggle' => 'modal',
                            'class' => 'btn btn-danger btn-xs activity-delete-type2',
                ]);
            },
        ],
    ];
}
if ($action == 'verify') {
    $actioncolumn1 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {select} {edit}',
        'pageSummary' => 'บาท',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
        'buttons' => [
            'select' => function ($url, $model, $key) {
                if ($model->POItemNumStatusID == 2) {
                    return Html::a(Icon::show('close') . 'Cancel', false, [
                                'title' => 'Cancel',
                                'class' => 'btn btn-warning btn-xs btn-cancel',
                    ]);
                } else {
                    return Html::a(Icon::show('check') . 'OK', false, [
                                'class' => 'btn btn-success btn-xs activity-ok-link',
                                'title' => 'Select',
                                'data-pjax' => '0',
                    ]);
                }
            },
            'edit' => function ($url, $model) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'title' => Yii::t('app', 'Edit'),
                            'class' => 'btn btn-primary btn-xs activity-update-link',
                ]);
            },
        ],
    ];
    //Type2
    $actioncolumn2 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {edit} {delete}',
        'pageSummaryOptions' => ['hidden' => true],
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'class' => 'btn btn-primary btn-xs activity-update-link',
                            'title' => Yii::t('app', 'Edit'),
                            'data-toggle' => 'modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::button(Icon::show('trash-o') . Yii::t('app', 'Delete'), [
                            'title' => Yii::t('app', 'Delete'),
                            'data-toggle' => 'modal',
                            'class' => 'btn btn-danger btn-xs activity-delete-link',
                ]);
            },
        ],
    ];
}
if (($action == 'view-verify') || ($action == 'view-reject') || ($action == 'view-approve') || ($action == 'approve-po')) {
    $actioncolumn1 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {select} {edit}',
        'pageSummary' => 'บาท',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
        'buttons' => [
            'select' => function ($url, $model, $key) {
                if ($model->POItemNumStatusID == 2) {
                    return Html::a(Icon::show('close') . 'Cancel', false, [
                                'title' => 'Cancel',
                                'class' => 'btn btn-warning btn-xs',
                                'disabled' => true,
                    ]);
                } else {
                    return Html::a(Icon::show('check') . 'OK', false, [
                                'class' => 'btn btn-success btn-xs',
                                'title' => 'Select',
                                'data-pjax' => '0',
                                'disabled' => true,
                    ]);
                }
            },
            'edit' => function ($url, $model) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'title' => Yii::t('app', 'Edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'disabled' => true,
                ]);
            },
        ],
    ];
    //Type2
    $actioncolumn2 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {edit} {delete}',
        'pageSummaryOptions' => ['hidden' => true],
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'class' => 'btn btn-primary btn-xs',
                            'title' => Yii::t('app', 'Edit'),
                            'data-toggle' => 'modal',
                            'disabled' => true,
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::button(Icon::show('trash-o') . Yii::t('app', 'Delete'), [
                            'title' => Yii::t('app', 'Delete'),
                            'data-toggle' => 'modal',
                            'class' => 'btn btn-danger btn-xs',
                            'disabled' => true,
                ]);
            },
        ],
    ];
}
if ($action == 'update-approve') {
    $actioncolumn1 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => '{edit}',
        'pageSummary' => 'บาท',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
        'buttons' => [
            'edit' => function ($url, $model) {
                if ($model->detail->POQty == $model->ChkReceived($model['ids'])) {
                    return '<span class="label label-success"><strong>รับสินค้าครบแล้ว!</strong></span>';
                } else {
                    return Html::a('Edit', false, [
                                'title' => 'Edit',
                                'data-toggle' => 'modal',
                                'class' => 'btn btn-primary btn-xs activity-update-link',
                    ]);
                }
            },
        ],
    ];
    //Type2
    $actioncolumn2 = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {edit} {delete}',
        'pageSummaryOptions' => ['hidden' => true],
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), false, [
                            'class' => 'btn btn-primary btn-xs activity-update-link',
                            'title' => Yii::t('app', 'Edit'),
                            'data-toggle' => 'modal',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::button(Icon::show('trash-o') . Yii::t('app', 'Delete'), [
                            'title' => Yii::t('app', 'Delete'),
                            'data-toggle' => 'modal',
                            'class' => 'btn btn-danger btn-xs activity-delete-link',
                ]);
            },
        ],
    ];
}
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
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode('รายละเอียดใบสั่งซื้อ') ?></h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <?php Pjax::begin(['id' => 'po_detail_1']) ?>
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
                        'detailUrl' => Url::to([$action == 'update' ? 'item-details' : 'item-details-verify']),
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
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model['PRApprovedUnitCost']) ? '-' : number_format($model['PRApprovedUnitCost'], 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                        [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
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
                        'hAlign' => GridView::ALIGN_CENTER,
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
                        'hAlign' => GridView::ALIGN_CENTER,
                        'pageSummary' => true,
                        'format' => ['decimal', 4],
                        'value' => function ($model) {
                            return empty($model->detail->POExtenedCost) ? '' : $model->detail->POExtenedCost;
                        },
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;background-color: #f5f5f5'],
                    ],
                    $actioncolumn1,
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
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode('รายละเอียดรายการยาแถม') ?></h3>
    </div>
    <div class="panel-body">
        <?php if (($action == 'update') || ($action == 'verify') || ($action == 'reject') || ($action == 'update-approve')) : ?>
            <p>
                <?= Html::a(Icon::show('plus', [], Icon::BSG) . 'เลือกรายการยาการค้า', false, ['class' => 'btn btn-success', 'onclick' => 'GetModalTableTPU(this);']); ?>
                <?= Html::a(Icon::show('plus', [], Icon::BSG) . 'เลือกรายการเวชภัณฑ์ฯ', false, ['class' => 'btn btn-success', 'onclick' => 'GetModalTableND(this);']); ?>
            </p>
        <?php endif; ?>
        <div class="form-group">
            <?php Pjax::begin(['id' => 'po_detail_2']) ?>

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
                        'detailUrl' => Url::to([$action == 'update' ? 'item-details' : 'item-details-verify']),
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
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return '-';
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                        [
                        'attribute' => 'PRUnit',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
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
                        'hAlign' => GridView::ALIGN_CENTER,
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
                        'hAlign' => GridView::ALIGN_CENTER,
                        'format' => ['decimal', 4],
                        'value' => function ($model) {
                            return empty($model->detail->POExtenedCost) ? '' : $model->detail->POExtenedCost;
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    $actioncolumn2,
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
            <?php Pjax::end() ?>
        </div>
    </div>
</div> 