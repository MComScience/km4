<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

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
                                'index.php?r=chemo/pttrp/delete-drugsetdetail',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#drugdetdetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#drugdetdetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
$this->registerJs($script1);
?>
<style>
    div#solution-modal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>
<?php Pjax::begin(['id' => 'drugdetdetail-pjax']); ?>
<div class="form-group">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <h5 class="success">
            <b><?= Html::encode('เปิดเส้น :'); ?></b>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-keep-vein', 'ids' => $model->chemo_regimen_ids, 'vn' => $model->pt_visit_number, 'drugsetid' => $drugsetid], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]); ?>
        </h5>
        <?=
        GridView::widget([
            'dataProvider' => $keepProvider,
            'responsive' => true,
            'layout' => $layout,
            'showPageSummary' => true,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'tableOptions' => [
                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
            ],
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn',
                    'width' => '25px',
                ],
                [
                    'header' => 'drugset_ids',
                    'attribute' => 'drugset_ids',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->drugset_ids) ? '-' : $model->drugset_ids;
            },
                ],
                [
                    'header' => 'cpoe_seq',
                    'attribute' => 'cpoe_seq',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->cpoe_seq) ? '-' : $model->cpoe_seq;
            },
                ],
//                [
//                    'header' => 'cpoe_parentid',
//                    'attribute' => 'cpoe_parentid',
//                    'contentOptions' => ['class' => 'text-left'],
//                    'headerOptions' => ['style' => 'color:black;'],
//                    'value' => function($model, $key, $index) {
//                return empty($model->cpoe_parentid) ? '-' : $model->cpoe_parentid;
//            },
//                ],
                [
                    'header' => 'cpoe_itemtype_decs',
                    'attribute' => 'cpoe_itemtype_decs',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
            },
                ],
                [
                    'header' => 'รหัสสินค้า',
                    'attribute' => 'ItemID',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemID) ? '-' : $model->ItemID;
            },
                ],
                [
                    'header' => 'รายการ',
                    'attribute' => 'ItemDetail',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
            },
                ],
                [
                    'header' => 'จำนวน',
                    'attribute' => 'ItemQty1',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
            },
                ],
                [
                    'header' => 'ราคา/หน่วย',
                    'attribute' => 'ItemPrice',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummary' => 'รวม',
                    'value' => function($model, $key, $index) {
                return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
            },
                ],
                [
                    'header' => 'จำนวนเงิน',
                    'attribute' => 'Item_Amt',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Amt) ? '' : $model->Item_Amt;
            },
                ],
                [
                    'header' => 'เบิกได้',
                    'attribute' => 'Item_Cr_Amt_Sum',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummary' => true,
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
            },
                ],
                [
                    'header' => 'เบิกไม่ได้',
                    'attribute' => 'Item_Pay_Amt',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummary' => true,
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Pay_Amt) ? '' : $model->Item_Pay_Amt;
            },
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                    'template' => '{update} {delete}',
                    'noWrap' => true,
                    'header' => 'Actions',
                    'buttons' => [
                        'update' => function ($key, $model) {
                            $url = ['edit-keep-vein', 'ids' => $model['drugset_ids']];
                            return Html::a('Edit', $url, [
                                        'title' => 'Edit',
                                        'class' => 'btn btn-info btn-xs',
                                        'role' => 'modal-remote',
                            ]);
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
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 col-sm-6 col-xs-12">
                <h5 class="success">
                    <b><?= Html::encode('Premedication :'); ?></b>
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-premedication', 'ids' => $model->chemo_regimen_ids, 'vn' => $model->pt_visit_number, 'drugsetid' => $drugsetid], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]); ?>
                </h5>
                <?=
                GridView::widget([
                    'dataProvider' => $premedProvider,
                    'responsive' => true,
                    'layout' => $layout,
                    'showPageSummary' => true,
                    'hover' => true,
                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                    'tableOptions' => [
                        'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                    ],
                    'columns' => [
                        [
                            'class' => '\kartik\grid\SerialColumn',
                            'width' => '25px',
                        ],
                        [
                            'header' => 'drugset_ids',
                            'attribute' => 'drugset_ids',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->drugset_ids) ? '-' : $model->drugset_ids;
                    },
                        ],
                        [
                            'header' => 'cpoe_seq',
                            'attribute' => 'cpoe_seq',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->cpoe_seq) ? '-' : $model->cpoe_seq;
                    },
                        ],
//                        [
//                            'header' => 'cpoe_parentid',
//                            'attribute' => 'cpoe_parentid',
//                            'contentOptions' => ['class' => 'text-left'],
//                            'headerOptions' => ['style' => 'color:black;'],
//                            'value' => function($model, $key, $index) {
//                        return empty($model->cpoe_parentid) ? '-' : $model->cpoe_parentid;
//                    },
//                        ],
                        [
                            'header' => 'cpoe_itemtype_decs',
                            'attribute' => 'cpoe_itemtype_decs',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                    },
                        ],
                        [
                            'header' => 'รหัสสินค้า',
                            'attribute' => 'ItemID',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->ItemID) ? '-' : $model->ItemID;
                    },
                        ],
                        [
                            'header' => 'รายการ',
                            'attribute' => 'ItemDetail',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                    },
                        ],
                        [
                            'header' => 'จำนวน',
                            'attribute' => 'ItemQty1',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'value' => function($model, $key, $index) {
                        return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                    },
                        ],
                        [
                            'header' => 'ราคา/หน่วย',
                            'attribute' => 'ItemPrice',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'pageSummary' => 'รวม',
                            'value' => function($model, $key, $index) {
                        return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
                    },
                        ],
                        [
                            'header' => 'จำนวนเงิน',
                            'attribute' => 'Item_Amt',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'pageSummary' => true,
                            'format' => ['decimal', 2],
                            'value' => function($model, $key, $index) {
                        return empty($model->Item_Amt) ? '-' : $model->Item_Amt;
                    },
                        ],
                        [
                            'header' => 'เบิกได้',
                            'attribute' => 'Item_Cr_Amt_Sum',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'pageSummary' => true,
                            'value' => function($model, $key, $index) {
                        return empty($model->Item_Cr_Amt_Sum) ? '-' : $model->Item_Cr_Amt_Sum;
                    },
                        ],
                        [
                            'header' => 'เบิกไม่ได้',
                            'attribute' => 'Item_Pay_Amt',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'color:black;'],
                            'pageSummary' => true,
                            'value' => function($model, $key, $index) {
                        return empty($model->Item_Pay_Amt) ? '-' : $model->Item_Pay_Amt;
                    },
                        ],
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                            'template' => '{updatetreat} {delete}',
                            'noWrap' => true,
                            'header' => 'Actions',
                            'buttons' => [
                                'updatetreat' => function ($key, $model) {
                                    $url = ['edit-premedication', 'ids' => $model['drugset_ids']];
                                    return Html::a('Edit', $url, [
                                                'title' => 'Edit',
                                                'class' => 'btn btn-info btn-xs',
                                                'role' => 'modal-remote',
                                    ]);
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
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12 col-sm-6 col-xs-12">
                        <h5 class="success">
                            <b><?= Html::encode('Chemo :'); ?></b>
                            <?=
                            Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
                            Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo Inj', ['create-inj', 'ids' => $model->chemo_regimen_ids, 'vn' => $model->pt_visit_number, 'drugsetid' => $drugsetid], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
                            ?>
                        </h5>
                        <?=
                        GridView::widget([
                            'dataProvider' => $ivProvider,
                            'responsive' => true,
                            'layout' => $layout,
                            'showPageSummary' => true,
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'tableOptions' => [
                                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                            ],
                            'columns' => [
                                [
                                    'class' => '\kartik\grid\SerialColumn',
                                    'width' => '25px',
                                ],
                                [
                                    'header' => 'drugset_ids',
                                    'attribute' => 'drugset_ids',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->drugset_ids) ? '-' : $model->drugset_ids;
                            },
                                ],
                                [
                                    'header' => 'cpoe_seq',
                                    'attribute' => 'cpoe_seq',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->cpoe_seq) ? '-' : $model->cpoe_seq;
                            },
                                ],
//                                [
//                                    'header' => 'cpoe_parentid',
//                                    'attribute' => 'cpoe_parentid',
//                                    'contentOptions' => ['class' => 'text-left'],
//                                    'headerOptions' => ['style' => 'color:black;'],
//                                    'value' => function($model, $key, $index) {
//                                return empty($model->cpoe_parentid) ? '-' : $model->cpoe_parentid;
//                            },
//                                ],
                                [
                                    'header' => 'cpoe_itemtype_decs',
                                    'attribute' => 'cpoe_itemtype_decs',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                            },
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'attribute' => 'ItemID',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemID) ? '-' : $model->ItemID;
                            },
                                ],
                                [
                                    'header' => 'รายการ',
                                    'attribute' => 'ItemDetail',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                            },
                                ],
                                [
                                    'header' => 'จำนวน',
                                    'attribute' => 'ItemQty1',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                            },
                                ],
                                [
                                    'header' => 'ราคา/หน่วย',
                                    'attribute' => 'ItemPrice',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'pageSummary' => 'รวม',
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
                            },
                                ],
                                [
                                    'header' => 'จำนวนเงิน',
                                    'attribute' => 'Item_Amt',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'pageSummary' => true,
                                    'format' => ['decimal', 2],
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                            },
                                ],
                                [
                                    'header' => 'เบิกได้',
                                    'attribute' => 'Item_Cr_Amt_Sum',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'pageSummary' => true,
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Cr_Amt_Sum) ? '-' : $model->Item_Cr_Amt_Sum;
                            },
                                ],
                                [
                                    'header' => 'เบิกไม่ได้',
                                    'attribute' => 'Item_Pay_Amt',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'color:black;'],
                                    'pageSummary' => true,
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Pay_Amt) ? '-' : $model->Item_Pay_Amt;
                            },
                                ],
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'template' => '{updatetreat} {delete}',
                                    'noWrap' => true,
                                    'header' => 'Actions',
                                    'buttons' => [
                                        'updatetreat' => function ($key, $model) {
                                            if ($model['cpoe_Itemtype'] == '50') {
                                                return Html::a('Edit', 'javascript:void(0);', [
                                                            'title' => 'Edit',
                                                            'onclick' => 'EditIVSolution(' . $model['drugset_ids'] . ');',
                                                            'class' => 'btn btn-info btn-xs'
                                                ]);
                                            } else {
                                                $url = ['edit-inj', 'ids' => $model['drugset_ids']];
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
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12 col-sm-6 col-xs-12">
                                <h5 class="success">
                                    <b><?= Html::encode('Medication :'); ?></b>
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-plus"></i>Drug', ['create-medication', 'ids' => $model->chemo_regimen_ids, 'vn' => $model->pt_visit_number, 'drugsetid' => $drugsetid], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
                                    Html::a('<i class="glyphicon glyphicon-plus"></i>Chemo P.O.', ['create-chemopo', 'ids' => $model->chemo_regimen_ids, 'vn' => $model->pt_visit_number, 'drugsetid' => $drugsetid], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
                                    ?>
                                </h5>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $medicatProvider,
                                    'responsive' => true,
                                    'layout' => $layout,
                                    'showPageSummary' => true,
                                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                    'tableOptions' => [
                                        'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                    ],
                                    'columns' => [
                                        [
                                            'class' => '\kartik\grid\SerialColumn',
                                            'width' => '25px',
                                        ],
                                        [
                                            'header' => 'drugset_ids',
                                            'attribute' => 'drugset_ids',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->drugset_ids) ? '-' : $model->drugset_ids;
                                    },
                                        ],
                                        [
                                            'header' => 'cpoe_seq',
                                            'attribute' => 'cpoe_seq',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->cpoe_seq) ? '-' : $model->cpoe_seq;
                                    },
                                        ],
                                        [
                                            'header' => 'cpoe_parentid',
                                            'attribute' => 'cpoe_parentid',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->cpoe_parentid) ? '-' : $model->cpoe_parentid;
                                    },
                                        ],
                                        [
                                            'header' => 'cpoe_itemtype_decs',
                                            'attribute' => 'cpoe_itemtype_decs',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                                    },
                                        ],
                                        [
                                            'header' => 'รหัสสินค้า',
                                            'attribute' => 'ItemID',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemID) ? '-' : $model->ItemID;
                                    },
                                        ],
                                        [
                                            'header' => 'รายการ',
                                            'attribute' => 'ItemDetail',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                                    },
                                        ],
                                        [
                                            'header' => 'จำนวน',
                                            'attribute' => 'ItemQty1',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                                    },
                                        ],
                                        [
                                            'header' => 'ราคา/หน่วย',
                                            'attribute' => 'ItemPrice',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'pageSummary' => 'รวม',
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemPrice) ? '-' : $model->ItemPrice;
                                    },
                                        ],
                                        [
                                            'header' => 'จำนวนเงิน',
                                            'attribute' => 'Item_Amt',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'pageSummary' => true,
                                            'format' => ['decimal', 2],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Amt) ? '-' : $model->Item_Amt;
                                    },
                                        ],
                                        [
                                            'header' => 'เบิกได้',
                                            'attribute' => 'Item_Cr_Amt_Sum',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'pageSummary' => true,
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Cr_Amt_Sum) ? '-' : $model->Item_Cr_Amt_Sum;
                                    },
                                        ],
                                        [
                                            'header' => 'เบิกไม่ได้',
                                            'attribute' => 'Item_Pay_Amt',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'headerOptions' => ['style' => 'color:black;'],
                                            'pageSummary' => true,
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Pay_Amt) ? '-' : $model->Item_Pay_Amt;
                                    },
                                        ],
                                        [
                                            'class' => '\kartik\grid\ActionColumn',
                                            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                            'template' => '{updatetreat} {delete}',
                                            'noWrap' => true,
                                            'header' => 'Actions',
                                            'buttons' => [
                                                'updatetreat' => function ($key, $model) {
                                                    if ($model['cpoe_Itemtype'] == 54) {
                                                        $url = ['edit-chemopo', 'ids' => $model['drugset_ids']];
                                                        return Html::a('Edit', $url, [
                                                                    'title' => 'Edit',
                                                                    'class' => 'btn btn-info btn-xs',
                                                                    'role' => 'modal-remote',
                                                        ]);
                                                    } else {
                                                        $url = ['edit-medication', 'ids' => $model['drugset_ids']];
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
                                    </div>
                                </div>
                                <?php Pjax::end(); ?>




                                <script>
                                    function GetmodalIVSolution() {
                                        var drugset_id = <?= "'" . $drugsetid . "'" ?>;
                                        var vn = <?= "'" . $model->pt_visit_number . "'" ?>;
                                        var regimen_ids = <?= "'" . $model->chemo_regimen_ids . "'" ?>;
                                        $.ajax({
                                            url: 'index.php?r=chemo/pttrp/ivsolution',
                                            type: 'get',
                                            data: {drugset_id: drugset_id, vn: vn, regimen_ids: regimen_ids},
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#solution-modal').find('.modal-body').html(data);
                                                $('#data').html(data);
                                                $('#solution-modal').modal('show');

                                            }
                                        });
                                    }

                                    function EditIVSolution(id) {
                                        $.ajax({
                                            url: 'index.php?r=chemo/pttrp/edit-ivsolution',
                                            type: 'post',
                                            data: {id: id},
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#solution-modal').find('.modal-body').html(data);
                                                $('#data').html(data);
                                                $('#solution-modal').modal('show');
                                            }
                                        });
                                    }
                                </script>
                                <?php
                                $title = '<i class="glyphicon glyphicon-user"></i>' . $header->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                                        $header->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                                        ' <span class="success">HN</span> ' . $header->pt_hospital_number . ' | ' .
                                        ' <span class="success">VN</span> ' . $header->pt_visit_number . ' | ' .
                                        ' <span class="success">AN</span> ' . $header->pt_admission_number . '&nbsp;&nbsp;';
                                Modal::begin([
                                    'id' => 'solution-modal',
                                    'header' => '<h4 class="modal-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $title . ' </span> ' . '</h4>',
                                    'size' => 'modal-lg modal-primary',
                                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                                        //'closeButton' => false,
                                ]);
                                ?>
                                <div id="data"></div>
                                <?php Modal::end(); ?>