<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
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
#Button Actions
if ($type == 'chemo') {
    $action = Html::a(Icon::show('plus', [], Icon::BSG) . 'เปิดเส้น', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => '21', 'modalhd' => $modalhd], ['class' => 'btn btn-success btn-sm autosave', 'role' => 'modal-remote',]) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => '22', 'modalhd' => $modalhd], ['class' => 'btn btn-success btn-sm autosave', 'role' => 'modal-remote',]) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-success btn-sm autosave', 'onclick' => 'GetmodalIVSolutionPremed(this);']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm autosave', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Injection', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => '53', 'modalhd' => $modalhd], ['class' => 'btn btn-success btn-sm autosave', 'role' => 'modal-remote',]) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Homemed', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => 'homemed', 'modalhd' => $modalhd], ['class' => 'btn btn-success btn-sm autosave', 'role' => 'modal-remote',]) . ' ' .
            Html::a(Icon::show('plus', [], Icon::BSG) . 'Hormones', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => '54', 'modalhd' => $modalhd], ['class' => 'btn btn-purple btn-sm autosave', 'role' => 'modal-remote']);
} elseif ($type == 'homemed') {
    $action = Html::a('<i class="glyphicon glyphicon-plus"></i>Drug', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => 'homemed', 'modalhd' => $modalhd], ['class' => 'btn btn-success btn-sm autosave', 'role' => 'modal-remote',]) . ' ' .
            Html::a('<i class="glyphicon glyphicon-plus"></i>Hormones', ['create-by-type', 'vn' => $header['pt_visit_number'], 'cpoeid' => $model['cpoe_id'], 'type' => '54', 'modalhd' => $modalhd], ['class' => 'btn btn-purple btn-sm autosave', 'role' => 'modal-remote',]);
}

//Script
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
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm : true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            setTimeout(function () {
                                swal("Deleted!", "", "success");
                                $.pjax.reload({container: '#cpoedetail-pjax'});
                            }, 1000);
                        }
                        );
                    }
                });
    });
    /* PrintSingle */
    $('.btn-printlabel').click(function (e) {
        var ids = $(this).closest('tr').data('key');
        swal({
            title: "Print?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        CheckPrint(ids);
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

<p>
    <?php // Html::a('Select Package', ['select-package', 'type' => $type, 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning']); ?>
</p>
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
        'before' =>
        $action,
        'after' => false,
    ],
    'toolbar' => [
            [
            'content' => Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']),
        ],
    ],
    /*
      'export' => [
      'fontAwesome' => true,
      'label' => 'พิมพ์ใบสรุปราคายา',
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
      'filename' => 'ใบสรุปราคายา',
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
      //                    'SetHeader' => $this->render('_header_report', [
      //                        'model' => $model,
      //                        'modelChemo' => $modelChemo,
      //                    ]),
      'SetFooter' => ['|Page {PAGENO}|'],
      ],
      'options' => [
      'title' => 'Report',
      'defaultheaderline' => 0,
      'defaultfooterline' => 0,
      ],
      ]
      ],
      ], */
    'columns' => [
//            [
//            'class' => '\kartik\grid\SerialColumn',
//            'width' => '25px',
//        ],
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
                        $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 22) {
                        $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
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
                        $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
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
<textarea id="tableitem" rows="50" cols="50" hidden=""><?php echo $druglistop; ?></textarea>
<script type="text/javascript">
    function CheckPrint(ids) {
        $.post(
                'check-print-label',
                {
                    ids: ids
                },
                function (result)
                {
                    if (result == 'duplicate') {
                        swal({
                            title: "ต้องการสั่งพิมพ์ซ้ำ ?",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#53a93f",
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            confirmButtonText: "Confirm",
                            showLoaderOnConfirm: true,
                        },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        PrintSingle(ids);
                                    }
                                });
                    } else {
                        PrintSingle(ids);
                    }
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
        });
    }

    function PrintSingle(ids) {
        $.post(
                'print-single-label',
                {
                    ids: ids
                },
                function (result)
                {
                    swal(result, "", "success");
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
        });
    }
</script>