<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

$iconplus = '<i class="glyphicon glyphicon-plus"></i>';

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<?php Pjax::begin(['id' => 'drugdetdetail-pjax']); ?>
<p>
    <span class="success"><b>Details :</b></span>
    <?=
    Html::a($iconplus . 'เปิดเส้น', ['create-keep-vein', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
    Html::a($iconplus . 'Premed', ['create-premedication', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
    Html::a($iconplus . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-success btn-sm', 'onclick' => 'GetmodalIVSolutionPremed(this);']) . ' ' .
    Html::a($iconplus . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
    Html::a($iconplus . 'Chemo Inj', ['create-inj', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]) . ' ' .
    Html::a($iconplus . 'Home med', ['create-medication', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
    Html::a($iconplus . 'Home med Chemo', ['create-chemopo', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
    ?>
</p>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
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
    /*
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> รายการ</h3>',
        'type' => GridView::TYPE_DEFAULT,
        'before' =>
        Html::a($iconplus . 'เปิดเส้น', ['create-keep-vein', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Premed', ['create-premedication', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-success btn-sm', 'onclick' => 'GetmodalIVSolutionPremed(this);']) . ' ' .
        Html::a($iconplus . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
        Html::a($iconplus . 'Chemo Inj', ['create-inj', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Home med', ['create-medication', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
        Html::a($iconplus . 'Home med Chemo', ['create-chemopo', 'drugset_id' => $modelDrugset['drugset_id'], 'chemo_id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]),
        'after' => false,
    ],*/
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
    'export' => [
        'fontAwesome' => true,
        'icon' => 'print',
        'showConfirmAlert' => FALSE,
        'stream' => false,
        'target' => '_blank',
        'showColumnSelector' => true
    ],
    'exportConfig' => [
        GridView::PDF => true,
        GridView::EXCEL => true,
    ],
    'columns' => [
        [
            'class' => '\kartik\grid\SerialColumn',
            'width' => '35px',
        ],
        [
            'header' => 'cpoe_itemtype_decs',
            'attribute' => 'cpoe_Itemtype',
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'value' => function($model, $key, $index) {
        return empty($model->cpoe_itemtype_decs) ? '' : $model->cpoe_itemtype_decs;
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
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
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
            'noWrap' => true,
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'value' => function($model, $key, $index) {
        return empty($model->ItemQty1) ? '' : $model->ItemQty1;
    },
        ],
        [
            'header' => 'ราคา/หน่วย',
            'attribute' => 'ItemPrice',
            'noWrap' => true,
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'pageSummary' => 'รวม',
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
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'format' => ['decimal', 2],
            'value' => function($model, $key, $index) {
        return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
    },
        ],
        [
            'header' => 'เบิกไม่ได้',
            'attribute' => 'Item_Pay_Amt',
            'contentOptions' => ['class' => 'text-right'],
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'pageSummary' => true,
            'noWrap' => true,
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'format' => ['decimal', 2],
            'value' => function($model, $key, $index) {
        return empty($model->Item_Pay_Amt) ? '' : $model->Item_Pay_Amt;
    },
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
            'template' => '{update} {delete}',
            'headerOptions' => ['style' => 'color:black;text-align:center;'],
            'noWrap' => true,
            'header' => 'Actions',
            'buttons' => [

                'update' => function ($key, $model) {
                    if ($model['cpoe_Itemtype'] == 21) {
                        $url = ['edit-keep-vein', 'ids' => $model['drugset_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 22) {
                        $url = ['edit-premedication', 'ids' => $model['drugset_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == '50' || $model['cpoe_Itemtype'] == '40') {
                        return Html::a('Edit', 'javascript:void(0);', [
                                    'title' => 'Edit',
                                    'onclick' => 'EditIVSolution(' . $model['drugset_ids'] . ');',
                                    'class' => 'btn btn-info btn-xs'
                        ]);
                    } else if ($model['cpoe_Itemtype'] == '53') {
                        $url = ['edit-inj', 'ids' => $model['drugset_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    }

                    if ($model['cpoe_Itemtype'] == 54) {
                        $url = ['edit-chemopo', 'ids' => $model['drugset_ids']];
                        return Html::a('Edit', $url, [
                                    'title' => 'Edit',
                                    'class' => 'btn btn-info btn-xs',
                                    'role' => 'modal-remote',
                        ]);
                    } else if ($model['cpoe_Itemtype'] == '10' || $model['cpoe_Itemtype'] == '20') {
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
        <?php Pjax::end(); ?>

        <script>
            function GetmodalIVSolution() {
                var drugset_id = <?= "'" . $modelDrugset->drugset_id . "'" ?>;
                var drugset_type = <?= "'" . $modelChemo->drugset_type . "'" ?>;
                var chemo_id = <?= "'" . $modelChemo->std_trp_chemo_id . "'" ?>;
                $.ajax({
                    url: 'index.php?r=chemos/standard/ivsolution',
                    type: 'get',
                    data: {drugset_id: drugset_id, drugset_type: drugset_type, chemo_id: chemo_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#solution-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('#solution-modal').modal('show');

                    }
                });
            }
            function GetmodalIVSolutionPremed() {
                var drugset_id = <?= "'" . $modelDrugset->drugset_id . "'" ?>;
                var drugset_type = <?= "'" . $modelChemo->drugset_type . "'" ?>;
                var chemo_id = <?= "'" . $modelChemo->std_trp_chemo_id . "'" ?>;
                $.ajax({
                    url: 'index.php?r=chemos/standard/ivsolution-premed',
                    type: 'get',
                    data: {drugset_id: drugset_id, drugset_type: drugset_type, chemo_id: chemo_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#solution-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('#solution-modal').modal('show');

                    }
                });
            }
            function EditIVSolution(id) {
                var drugset_type = <?= "'" . $modelChemo->drugset_type . "'" ?>;
                var chemo_id = <?= "'" . $modelChemo->std_trp_chemo_id . "'" ?>;
        $.ajax({
            url: 'index.php?r=chemos/standard/edit-ivsolution',
            type: 'get',
            data: {id: id, drugset_type: drugset_type, chemo_id: chemo_id},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');
            }
        });
    }
</script>