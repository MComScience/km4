<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
use frontend\assets\SweetAlertAsset;
use kartik\popover\PopoverX;

SweetAlertAsset::register($this);
#GridView Header Style
$headerOption = ['style' => 'text-align:center;color:black;background-color: #ffffff'];
#Actions
$action = Yii::$app->controller->action->id;
#GridLayout
$layout = <<< HTML
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

if ($type == 'new' || $type == 'edit') {
    #Button Select
    $ButtonSelect = Html::a(Icon::show('plus') . 'เลือกยาสามัญ', false, ['class' => 'btn btn-success', 'onclick' => 'GetModalTableGPU(this);', 'title' => 'เลือกรายการยาสามัญ']);
    $ButtonSetting = PopoverX::widget([
                'header' => 'Settings',
                'type' => PopoverX::TYPE_SUCCESS,
                'placement' => PopoverX::ALIGN_LEFT,
                'content' =>
                '<div class="checkbox">'
                . '<label>'
                . Html::input('text', 'Auto PRNum', '', ['type' => 'checkbox', 'id' => 'autogen-prnum'])
                . Html::tag('span', Html::encode('Auto Generate PRNum'), ['class' => 'text'])
                . '</label>'
                . '</div>',
                'footer' => false,
                'toggleButton' => ['label' => Icon::show('cog', [], Icon::BSG), 'class' => 'btn btn-default', 'title' => 'Setting'],
    ]);
    $ButtonActions = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'pageSummary' => 'บาท',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {update} {delete}',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                /*
                  return Html::button(Icon::show('edit'), [
                  'value' => Url::to(['update-detailgpu', 'id' => $model['ids']]),
                  'title' => Yii::t('app', 'Edit'),
                  'class' => 'ModalAjax btn btn-primary btn-xs',
                  'modalId' => '#gpu-modal',
                  'modalContent' => '#data',
                  'modalTitle' => 'ปรับปรุงรายการยาสามัญ ใบขอซื้อ',
                  ]);
                 * */
                return Html::button(Icon::show('edit') . 'Edit', [
                            'class' => 'btn btn-primary btn-xs activity-update-link',
                            'title' => Yii::t('app', 'Edit'),
                            'data-toggle' => 'modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::button(Icon::show('trash-o') . 'Delete', [
                            'title' => 'Delete',
                            'data-toggle' => 'modal',
                            'class' => 'btn btn-danger btn-xs activity-delete-link',
                ]);
            },
        ],
    ];
} else if ($type == 'view' || $type == 'approve' || $type == 'reject') {
    $ButtonSelect = Html::button(Icon::show('plus') . 'เลือกยาสามัญ', ['disabled' => true, 'class' => 'btn btn-success',]);
    $ButtonSetting = Html::button(Icon::show('cog', [], Icon::BSG), ['class' => 'btn btn-primary', 'disabled' => true]);
    $ButtonActions = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'headerOptions' => ['hidden' => true],
        'noWrap' => true,
        'pageSummary' => 'บาท',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
        'hAlign' => GridView::ALIGN_CENTER,
        'template' => '',
    ];
} elseif ($type == 'verify') {
    $ButtonActions = [
        'class' => 'kartik\grid\ActionColumn',
        'noWrap' => true,
        'pageSummary' => 'บาท',
        'options' => ['style' => 'width:100px;'],
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['hidden' => true],
        'template' => ' {ok} {update}',
        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
        'buttons' => [
            'ok' => function ($url, $model) {
                if ($model->PRVerifyQty > 0.00) {
                    return Html::a(Icon::show('close') . 'Cancel', "#", [
                                'title' => 'Cancel',
                                'class' => 'btn btn-warning btn-xs btn-cancel',
                                'data-toggle' => 'modal',
                    ]);
                } else {
                    return Html::a(Icon::show('check') . 'OK', '#', [
                                'title' => 'OK',
                                'data-toggle' => 'modal',
                                'class' => 'btn btn-success btn-xs activity-ok-link',
                    ]);
                }
            },
            'update' => function ($url, $model, $key) {
                return Html::a(Icon::show('edit') . 'Edit', '#', [
                            'class' => 'btn btn-primary btn-xs activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
        ],
    ];
}
?>
<style>
    table.kv-grid-table th{
        white-space: nowrap;
    }
    table.kv-grid-table thead tr th{
        font-size: 11pt;
    }
    table#datatable-gpu thead tr th{
        border-top: 1px solid #ddd;
        text-align: center;
        white-space: nowrap;
    }
</style>
<?php if ($action == 'update' || $action == 'update-reject-verify' || $action == 'view' || $action == 'view-reject-verify') : ?>
    <div class="form-group">
        <div class="col-sm-12">
            <div style="text-align: left;">
                <?php
                echo $action == 'update-reject-verify' ? $ButtonSelect : $ButtonSelect;
                ?>
            </div>
            <?php Pjax::begin(['id' => 'detail_gpu_pjax']) ?>
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
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '33px',
                        'header' => '#',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['colspan' => '6'],
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
                        'detailUrl' => Url::to([$action == 'update-reject-verify' || $action == 'view-reject-verify' ? 'item-details-verify' : 'item-details']),
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
                            return $model->ItemName.' '. $model->getSatusOnplan($model['PRItemOnPCPlan']);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PROrderQty',
                        'header' => 'ขอซื้อ', #จำนวน
                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ffffff;', 'colspan' => 3],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'label' => false,
                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ffffff;'],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'value' => function ($model) {
                            return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnit',
                        'header' => 'Actions',
                        'headerOptions' => $headerOption,
                        'pageSummaryOptions' => ['style' => 'text-align:center;font-size:12pt;'],
                        'noWrap' => true,
                        'pageSummary' => Yii::t('app', 'Total'),
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return empty($model->detail->PRUnit) ? '-' : $model->detail->PRUnit;
                        }
                    ],
                    [
                        'attribute' => 'PRExtendedCost',
                        'headerOptions' => ['hidden' => true],
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['decimal', 4],
                        'pageSummary' => true,
                        'pageSummaryOptions' => ['style' => 'text-align:right;font-size:12pt;'],
                        'value' => function ($model) {
                            return $model->PRExtendedCost;
                        }
                    ],
                    $ButtonActions,
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'hidden' => true,
                        'group' => true, // enable grouping
                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                            return [
                                'mergeColumns' => [
                                    [1, 3],
                                    [8, 9]
                                ], // columns to merge in summary
                                'content' => [// content to show in each summary cell
                                    1 => '',
                                    #2 => 'รหัสยาสามัญ',
                                    #3 => 'รายละเอียดยา',
                                    4 => 'จำนวน',
                                    5 => 'ราคา/หน่วย',
                                    6 => 'หน่วย',
                                    7 => 'ราคารวม',
                                ],
                                'contentOptions' => [// content html attributes for each summary cell
                                    0 => ['style' => 'background-color: #ffffff'],
                                    1 => ['style' => 'font-variant:small-caps;color:black;background-color: #ffffff'],
                                    2 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    3 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    4 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap;'],
                                    5 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap;'],
                                    6 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap;'],
                                    7 => ['style' => 'text-align:center;color:black;background-color: #ffffff;white-space: nowrap;'],
                                    8 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
                                    9 => ['style' => 'text-align:center;color:black;background-color: #ffffff'],
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
<?php endif; ?>

<?php if ($action == 'verify-pr' || $action == 'approve-pr' || $action == 'view-verify') : ?>

    <div class="form-group">
        <div class="col-sm-12">
            <h5 class="row-title before-success"><?= Html::encode('รายละเอียดใบขอซื้อ'); ?></h5>
            <?php Pjax::begin(['id' => 'verify_gpu_pjax']) ?>
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
                            return $model->getUnit();
                        },
                        'pageSummaryOptions' => ['hidden' => true],
                    ],
                    [
                        'attribute' => 'PRUnitCost',
                        'header' => Html::encode('Actions'),
                        'headerOptions' => $headerOption,
                        'hAlign' => GridView::ALIGN_CENTER,
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
                            return empty($model['PRVerifyQty']) ? '-' : $model->getVerifyUnit();
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
                            return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 2);
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
                    $ButtonActions,
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
            <?php Pjax::end() ?>
        </div>
    </div>
<?php endif; ?>

