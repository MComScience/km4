<?php

use kartik\grid\GridView;
use kartik\helpers\Html;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);

$this->title = 'ประวัติขอเบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_D").addClass("active");');
$count = $dataProvider->getTotalCount();
?>
<div class="tbsr2-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
             <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
             <?php if($count =='0') :?>
            <table class="default kv-grid-table table table-hover table-bordered  table-condensed dataTable no-footer" width="100%">
                <thead>
                    <tr >
                        <th style="text-align: center;">
                            ลำดับ
                        </th>
                        <th style="text-align: center;">
                            เลขที่เบิก
                        </th>
                        <th style="text-align: center;">
                            วันที่
                        </th>
                        <th style="text-align: center;">
                            ขอเบิกจาก
                        </th>
                        <th style="text-align: center;">
                            รับเข้า
                        </th>
                        <th style="text-align: center;">
                            ประเภทขอเบิก
                        </th>
                        <th style="text-align: center;">
                            สถานะใบขอเบิก
                        </th>
                        <th style="text-align: center;">
                            อนุมัติโดย
                        </th>
                        <th style="text-align: center;">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="9" style="text-align: center;">No matching records found</td>
                </tbody>
            </table>
        <?php else : ?>
            <?php //echo $this->render('_search', ['model' => $searchModel, 'type' => 'history']); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'bordered' => true,
                'layout' => "{items}",
                'responsive' => false,
                'showOnEmpty' => false,
                'export' => false,
                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT,'style' => 'width:100%'],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'header' => 'ลำดับ',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']
                    ],
                    [
                        'header' => 'เลขที่ใบเบิก',
                        'attribute' => 'SRNum',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ],
                    [

                        'header' => 'วันที่',
                        'attribute' => 'SRDate',
                        'hAlign' => 'center',
                        'format' => ['date', 'php:d/m/Y'],
                        'headerOptions' => ['style' => 'color:black'],
                    ],
                    [
                        'header' => 'ขอเบิกจาก',
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    ,
                    [

                        'header' => 'รับเข้า',
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    , [
                        'header' => 'ประเภทการขอเบิก',
                        'headerOptions' => ['style' => 'color:black'],
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
                    ],
                    [
                        'header' => 'สถานะใบขอเบิก',
                        'attribute' => 'SRStatusDesc',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                    ],
                    [
                        'header' => 'อนุมัติโดย',
                        'attribute' => 'SRCreateBy',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->SRCreateBy == NULL) {
                                return '-';
                            } else {
                                return $model->SRCreateBy;
                            }
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => 'Actions',
                        'headerOptions' => ['style' => 'color:black'],
                        'noWrap' => true,
                        'template' => ' {update}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                $url = '/km4/Inventory/stock-request/history-detail?id=' . $key;
                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url.'&type=history', [
                                            'title' => 'Detail',
                                            'data-pjax' => 0
                                ]);
                            },
                                    'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-delete-link',
                                ]);
                            },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php endif; ?>
                    <?php yii\widgets\Pjax::end() ?>
                    <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
                    </div>
                </div>
            </div>
        </div>
<?php
$script = <<< JS
jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function (a) {
        if (a == null || a == "") {
            return 0;
        }
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },

    "date-uk-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-uk-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
    "currency-pre": function (a) {
        a = (a === "-") ? 0 : a.replace(/(.*-)/i, "");
        return parseFloat(a);
    },
    "currency-asc": function (a, b) {
        return a - b;
    },

    "currency-desc": function (a, b) {
        return b - a;
    }
});
$(document).ready(function () {
    $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": -1,
        "responsive": true,
        "columns": [
            null,
            {type: 'currency', targets: 0},
            {type: 'date-uk', targets: 0},
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ],
        "language": {
            "search": "ค้นหา : _INPUT_ ",
            /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
            "lengthMenu": "_MENU_",
            "infoEmpty": "No records available",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            //"infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "columnDefs": [
            {type: 'date-uk', targets: 0}
        ],
        /*"paging":   false,
         "ordering": false,
         "info":     false*/
    });
});
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "error",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                '/km4/Inventory/stock-request/delete2',
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#grid-user-pjax'});
                                }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script);
?>
