<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
CrudAsset::register($this);

$script = <<< JS
$(document).ready(function () {
        $('li.TabA').addClass("active");
        
        var table = $('#datatables_w1').DataTable();
        $('#min, #max').keyup(function () {
            table.draw();
        });
        $("input[id=แสดงรายการตามแผน]").click(function () {
            if ($(this).is(':checked')) {
                $('#plan_qty').val('0');
                table.draw();
            } else {
                $('#plan_qty').val('');
                table.draw();
            }
        });
        $("input[id=ต่ำกว่าจุดสั่งซื้อ]").click(function () {
            if ($(this).is(':checked')) {
                $('#stk_main_rop').val('0');
                table.draw();
            } else {
                $('#stk_main_rop').val('');
                table.draw();
            }
        });
        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = parseInt($('#stk_main_rop').val(), 10);
                    var max = parseInt($('#plan_qty').val(), 10);
                    var stk_main_rop = parseFloat(data[8].replace(/[,]/g, "")) || 0; // use data for the age column
                    var plan_qty = parseFloat(data[6].replace(/[,]/g, "")) || 0;
                    if (
                            (isNaN(min) && isNaN(max)) ||
                            (stk_main_rop < 0 && isNaN(max)) ||
                            (plan_qty < 0 && isNaN(min))
                            //(min < Item_Cr_Amt && isNaN(max)) ||
                            //(min < Item_Cr_Amt && ItemQtyAvalible < max)
                            )
                    {
                        return true;
                    }
                    return false;
                }
        );
});
function init_click_handlers() {
    $('.activity-stockcard-link').click(function (e) {
       var stkid = $(this).closest('tr').children('td:eq(6)').text();
       var itemid = $(this).closest('tr').children('td:eq(2)').text();
              $.post(
                        'index.php?r=Inventory/dashboard-sub/view-stockcard',
                        {
                            itemid: itemid, stkid: stkid
                        },
                function (data)
                {
                     $('#_result').html(data.html);
                            $('#itemid').html(data.itemid);
                            $('#itemname').html(data.itemname);
                            $('#tpu_sr2_detail_list').modal('show');
                            $('#data_tpu').DataTable({
                                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "pageLength": 10,
                                responsive: true,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": "ค้นหา "
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            });
                },
                'json'
             );
         });
  
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs('$("#tab_C").addClass("active");');

$sort = '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="แสดงรายการตามแผน" type="checkbox" /><span class="text"></span> แสดงรายการตามแผน</label>'
        . '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="ต่ำกว่าจุดสั่งซื้อ" type="checkbox" /><span class="text"></span> ต่ำกว่าจุดสั่งซื้อ</label>';
$btnprint = '<div class="btn-group">
    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100"><i class="glyphicon glyphicon-export"></i><b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li>
            <a href="index.php?r=Purchasing/dashboard/export-pdf&type=1" target="_blank" data-pjax="0"><i class="text-danger fa fa-file-pdf-o"></i> PDF</a>
        </li>
        <li>
            <a href="index.php?r=Purchasing/dashboard/export-excel&type=1" target="_blank" data-pjax="0"><i class="text-success fa fa-file-excel-o"></i> Excel</a>
        </li>
    </ul>
</div>';
$this->title = 'สถานะสินค้าคงคลัง';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.kv-grid-table thead tr th{
        background-color: white;

    }
    table#datatables_w1 th {
        white-space: nowrap;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
    .modal-body{
        background-color: #f5f5f5;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tabnew', ['model' => $searchModel, 'action' => 'list-drugnew']); ?>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?php Pjax::begin(); ?> 
                            <?=
                            fedemotta\datatables\DataTables::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'tableOptions' => [
                                    'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                ],
                                'options' => [
                                    'retrieve' => true
                                ],
                                'clientOptions' => [
                                    'bSortable' => false,
                                    'bAutoWidth' => true,
                                    'ordering' => false,
                                    'pageLength' => 20,
                                    //'bFilter' => false,
                                    'language' => [
                                        'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                        'lengthMenu' => '_MENU_',
                                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                        //'search' => '_INPUT_'.$this->render('');
                                    ],
                                    "lengthMenu" => [[10, 20, 40, 60, -1], [10, 20, 40, 60, "All"]],
                                    "responsive" => true,
                                    "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                ],
                                'columns' => [
                                        [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;'],
                                    ],
                                        [
                                        'header' => 'คลังสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'StkName',
                                        'contentOptions' => ['style' => 'text-align:center;',],
                                        'value' => function ($model) {
                                            return empty($model['StkName']) ? '-' : $model['StkName'];
                                        }
                                    ],

                                        [
                                        'header' => 'รหัสสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemID',
                                        'contentOptions' => ['style' => 'text-align:center;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                        }
                                    ],
                                        [
                                        'header' => 'รายละเอียดสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemName',
                                        'contentOptions' => ['style' => 'text-align:left;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                        }
                                    ],
                                        [
                                        'header' => 'ยอดคงคลัง',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7', 'noWrap' => true,],
                                        'attribute' => 'ItemQtyBalance',
                                        'contentOptions' => ['style' => 'text-align:left;'],
                                        'options' => ['style' => 'background-color: #d9edf7'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                            return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                                        }
                                    ],
                                        [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3', 'noWrap' => true,],
                                        'attribute' => 'DispUnit',
                                        'contentOptions' => ['style' => 'text-align:center;'],
                                        'options' => ['style' => 'background-color: #fcf8e3'],
                                        'value' => function ($model) {
                                            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                        }
                                    ],
                                        [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'template' => '{stockcard}',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'buttons' => [
                                            // 'view' => function ($url, $model,$key) {
                                            //     return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', ['details', 'id' => $key,'ItemName' => $model['ItemName'],'GPU' => $model['TMTID_GPU']], [
                                            //                 'title' => 'Rx Order',
                                            //                 'role' => 'modal-remote'
                                            //     ]);
                                            // },
                                            'stockcard' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span>', '#', 
                                                [
                                                    'title' => 'stockcard',
                                                    'onclick' => 'selectdetail(this);',
                                                    'stkid' => $model['StkID'],
                                                    'itemid' => $model['ItemID'],
                                                    'class' => 'activity-stockcard-link',
                                                ]);
                                            },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: right;">
                            <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<input type="hidden"  id="stk_main_rop" name="min">
<input type="hidden"  id="plan_qty" name="max">
<script>
    function  selectdetail(e) {
        var itemid = e.getAttribute('itemid');
        var stkid = e.getAttribute('stkid');
        $.ajax({
            url: 'index.php?r=Inventory/dashboard-sub/view-stockcard',
            type: 'POST',
            data: {itemid: itemid, stkid: stkid},
            dataType: 'json',
            success: function (data) {
                $('#_result').html(data.html);
                $('#itemid').html(data.itemid);
                $('#itemname').html(data.itemname);
                $('#tpu_sr2_detail_list').modal('show');
                $('#data_tpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    responsive: true,
                    "language": {
                        "lengthMenu": " _MENU_ ",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": "ค้นหา "
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ]
                });
            }
        });
    }
</script>
<?php
Modal::begin([
        'id' => 'tpu_sr2_detail_list',
        'header' => '<h4 class="modal-title">Stock Card</h4>',
        'size' => 'modal-lg modal-primary',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'closeButton' => FALSE,
        'footer' => Html::button('Close', ['data-dismiss' => 'modal','class' => 'btn btn-default']),
    ]);
?>
<?php echo '<div id="_result"></div>';?>
<?php Modal::end(); ?>