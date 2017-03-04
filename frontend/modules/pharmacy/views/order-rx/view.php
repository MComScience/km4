<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>
<div class="tb-cpoe-view">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'layout' => '<div class="pull-right">{toolbar}</div>
                            <div class="clearfix"></div><p></p>
                            {items}
                            <div class="clearfix"></div>
                            <div class="pull-left">{summary}</div>
                            <div class="pull-right">{pager}</div>
                            <div class="clearfix"></div>',
        'showPageSummary' => true,
        'striped' => false,
        'condensed' => true,
        'hover' => true,
        'bordered' => true,
        'headerRowOptions' => [
            'class' => GridView::TYPE_DEFAULT
        ],
        'pjax' => false,
        'export' => false,
        'toggleData' => false,
        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details ',
            //. Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']) . '</h3>',
            'type' => GridView::TYPE_SUCCESS,
            'before' => Html::a('Re med', false, ['class' => 'btn btn-success', 'onclick' => 'GetModalcreate(' . $modelCpoe['pt_vn_number'] . ')']),
            'after' => false,
        ],
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
                'contentOptions' => ['style' => 'height:46px;text-align:left;font-size: 13pt;vertical-align: middle;background-color: #f5f5f5;color: #53a93f;',],
                'headerOptions' => ['style' => 'color:black;'],
                'value' => function($model, $key, $index) {
                    return $model->cpoe_Itemtype == '41' || $model->cpoe_Itemtype == '42' || $model->cpoe_Itemtype == '51' || $model->cpoe_Itemtype == '52' ? '-' : $model->cpoe_itemtype_decs;
                },
                'hAlign' => 'center',
                'noWrap' => true,
                'group' => true, // enable grouping,
//            'groupedRow' => true,// move grouped column to a single grouped row
//            'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
//            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
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
                'class' => '\kartik\grid\CheckboxColumn',
                'header' => Html::checkBox('selection_all', false, [
                    'class' => 'select-on-check-all',
                    'label' => '<span class="text"></span>',
                    'value' => null
                ]),
                'checkboxOptions' => ['label' => '<span class="text"></span>',],
                'rowSelectedClass' => GridView::TYPE_SUCCESS,
            ],
        ],
    ]);
    ?>
</div>
<script type="text/javascript">
    $('.select-on-check-all').click(function (e) {
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked', true);
        } else {
            $('input[type=checkbox]').prop('checked', false);
        }
    });
    function GetModalcreate(vn) {
        var cpoeids = new Array();
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                cpoeids.push($(this).val());
            }
        });
        if (cpoeids.length <= 0) {
            swal({
                title: "โปรดเลือกรายการ!",
                text: "",
                type: "warning",
                confirmButtonText: "OK"
            });
        } else {
            $.ajax({
                type: 'GET',
                url: 'query-ardetail2',
                data: {VN: vn},
                dataType: "JSON",
                success: function (result) {
                    $('.name').html(result.name);
                    $('#content-remedmodal').html(result.table);
                    $('#VN').val(vn);
                    $('#create-modal').modal('show');
                },
                error: function (xhr, status, error) {
                    swal({
                        title: error,
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                },
            });
        }
    }
    function CreateRxOrder(type, schd) {
        var VN = $('#VN').val() || null;
        var cpoeids = new Array();
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                cpoeids.push($(this).val());
            }
        });
        window.location.href = 'create-history?data=' + VN + '&type=' + type + '&schd=' + schd + '&cpoeids=' + cpoeids;
    }


</script>
