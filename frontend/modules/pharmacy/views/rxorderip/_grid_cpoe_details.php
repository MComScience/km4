<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$iconplus = '<i class="glyphicon glyphicon-plus"></i>';

$script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=pharmacy/rxorderip/delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#cpoedetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#cpoedetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
$this->registerJs($script1);
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
    'toggleData' => false,
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details</h3>',
        'type' => GridView::TYPE_DEFAULT,
        'before' =>
        Html::a($iconplus . 'เปิดเส้น', ['create-keep-vein', 'vn' => $header->pt_visit_number, 'cpoeid' => $model['cpoe_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Premed', ['create-premedication', 'vn' => $header->pt_visit_number, 'cpoeid' => $model['cpoe_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-success btn-sm', 'onclick' => 'GetmodalIVSolutionPremed(this);']) . ' ' .
        Html::a($iconplus . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
        Html::a($iconplus . 'Chemo Inj', ['create-inj', 'vn' => $header->pt_visit_number, 'cpoeid' => $model['cpoe_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Homemed', ['create-medication', 'vn' => $header->pt_visit_number, 'cpoeid' => $model['cpoe_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Homemed Chemo', ['create-chemopo', 'vn' => $header->pt_visit_number, 'cpoeid' => $model['cpoe_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]),
        'after' => false,
    ],
    'export' => [
        'fontAwesome' => true,
        'label' => '<b>สรุปรายการยา</b>',
        'class' => 'btn btn-default',
        'icon' => 'print',
        'showConfirmAlert' => FALSE,
        'header' => '',
        'stream' => false,
        'target' => '_blank',
    ],
    'exportConfig' => [
        //GridView::EXCEL => ['label' => 'EXCEL', 'filename' => empty($model['cpoe_num']) ? 'Report' : $model['cpoe_num'],],
        GridView::PDF => [
            'label' => Yii::t('app', 'PDF'),
            'iconOptions' => ['class' => 'text-danger'],
            'filename' => 'สรุปรายการยา',
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
                'marginTop' => 35,
                'marginBottom' => 20,
                'marginHeader' => 10,
                'methods' => [
                    'SetHeader' => $this->render('_header_report', [
                        'model' => $model,
                        'modelChemo' => $modelChemo,
                    ]),
                    'SetFooter' => ['|Page {PAGENO}|'],
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
            'class' => '\kartik\grid\SerialColumn',
            'width' => '25px',
        ],
        [
            'header' => 'cpoe_itemtype_decs',
            'attribute' => 'cpoe_itemtype_decs',
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['style' => 'color:black;'],
            'value' => function($model, $key, $index) {
        return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
    },
            'group' => true, // enable grouping,
            'groupedRow' => true, // move grouped column to a single grouped row
            'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        ],
        [
            'header' => 'รหัสสินค้า',
            'attribute' => 'ItemID',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black; text-align:center;'],
            'value' => function($model, $key, $index) {
        return empty($model->ItemID) ? '-' : $model->ItemID;
    },
        ],
        [
            'header' => 'รายการ',
            'attribute' => 'ItemDetail',
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'value' => function($model, $key, $index) {
        return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
    },
        ],
        [
            'header' => 'จำนวน',
            'attribute' => 'ItemQty1',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'noWrap' => true,
            'value' => function($model, $key, $index) {
        return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
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
            'template' => '{update} {delete}',
            'noWrap' => true,
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'header' => 'Actions',
            'buttons' => [
                'update' => function ($key, $model) {
                    if ($model['cpoe_Itemtype'] == 21) {
                        $url = ['edit-keep-vein', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 22) {
                        $url = ['edit-premedication', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == '50' || $model['cpoe_Itemtype'] == '40') {
                        return Html::a('Edit', 'javascript:void(0);', [
                                    'title' => 'Edit',
                                    'onclick' => 'EditIVSolution(' . $model['cpoe_ids'] . ');',
                                    'class' => 'btn btn-info btn-xs'
                        ]);
                    } else if ($model['cpoe_Itemtype'] == '53') {
                        $url = ['edit-inj', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 54) {
                        $url = ['edit-chemopo', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    } else if ($model['cpoe_Itemtype'] == 10 || $model['cpoe_Itemtype'] == 20) {
                        $url = ['edit-medication', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }
                },
                        'delete' => function ($url, $model) {
                    return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                'title' => 'Delete',
                                'data-toggle' => 'modal',
                                'class' => 'activity-delete-link',
                    ]);
                },
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>