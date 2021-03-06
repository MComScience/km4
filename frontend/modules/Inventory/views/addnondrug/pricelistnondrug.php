<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use fedemotta\datatables\DataTables;

$this->title = 'เวชภัณฑ์';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการราคาสินค้า', 'url' => ['pricelistnondrug']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('ราคาสินค้า-เวชภัณฑ์'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-item-index">
                       <?php Pjax::begin(['id' => 'tb_item_pjax_pricelistnondrug']); ?>
                        <?php // echo $this->render('_search', ['model' => $searchModel, 'action' => 'pricelistnondrug']); ?>
                        <?=
                        DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'default kv-grid-table table table-hover table-bordered table-condensed',
                            ],
                            'options' => [
                                'retrieve' => true
                            ],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'clientOptions' => [
                                'bSortable' => false,
                                'bAutoWidth' => true,
                                'ordering' => false,
                                'pageLength' => 10,
                                //'bFilter' => false,
                                'language' => [
                                    'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                    'lengthMenu' => '_MENU_',
                                    'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                    'search' => '_INPUT_'
                                ],
                                "lengthMenu" => [[10, -1], [10, "All"]],
                                "responsive" => true,
                                "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px'],
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'attribute' => 'ItemID',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'header' => 'รายละเอียดสินค้า',
                                    'attribute' => 'ItemName',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'header' => 'ราคา',
                                    'attribute' => 'ItemPrice',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'หน่วย',
                                    'attribute' => 'DispUnit',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function($model){
                                        return  empty($model->DispUnit) ? '-' : $model->DispUnit;
                                    }
                                ],
                                [
                                    'header' => 'บัตรทอง',
                                    'attribute' => 'cr_price_0',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'ข้าราชการ',
                                    'attribute' => 'cr_price_1',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'อปท.',
                                    'attribute' => 'cr_price_2',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'รัฐวิสาหกิจ',
                                    'attribute' => 'cr_price_3',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'ปกส.',
                                    'attribute' => 'cr_price_4',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'ประกันสุขภาพเอกชน',
                                    'attribute' => 'cr_price_5',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'คปภ.',
                                    'attribute' => 'cr_price_6',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'องค์กรอิสระ',
                                    'attribute' => 'cr_price_7',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'header' => 'เฉพาะกลุ่ม',
                                    'attribute' => 'cr_price_8',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['class' => 'text-right'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{edit}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        /* Edit */
                                        'edit' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-info btn-xs btn-group"> แก้ไขราคาสินค้า </span>', '#', [
                                                        'title' => 'แก้ไขรายการสินค้า',
                                                        'class' => 'activity-update-link',
                                                        'data-toggle' => 'modal',
                                                        //'data-target' => '#modaleditprice',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                        },
                                            ],
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end(); ?>
                                <br/>
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>

            </div>
        </div>

        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'modaleditprice',
            'header' => '<h4 class="modal-title"></h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => false,
           // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
        ]);
        ?>
        <div id="data"></div>
        <?php \yii\bootstrap\Modal::end(); ?>

        <!--/Modal บันทึก -->
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'modaladditem',
            'header' => '<h4 class="modal-title1"></h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => false,
           // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
        ]);
        ?>
        <div id="from_additem"></div>
        <?php \yii\bootstrap\Modal::end(); ?>

        <?php
        $script = <<< JS
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $('.page-content').waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
        $.get(
                'index.php?r=Inventory/addnondrug/edit-credit',
                {
                    id: fID
                },
        function (data)
        {
            $('#from_additemprice').trigger('reset');
            $('#modaleditprice').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('รหัสสินค้า : ' + fID);
            $('.page-content').waitMe('hide');
            $('#modaleditprice').modal('show');
        }
        );
    });
}
init_click_handlers(); //first run
$("#tb_item_pjax_pricelistnondrug").on("pjax:success", function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});             
JS;
        $this->registerJs($script);
        ?>

<script>
    /* บันทึกราคาขาย */
    function Addpricenondrug() {
        var ItemID = $("#tbitem-itemid").val();
        var ItemName = $("#tbitem-itemname").val();
        var DispUnit = $("#tbitem-itemdispunit").val();
        var id = '';
        $.ajax({
            url: "index.php?r=Inventory/addnondrug/checkitemidprice",
            type: "post",
            data: {ItemID: ItemID},
            dataType: "JSON",
            success: function (result) {
                if (result != null) {
                    swal({
                        title: "",
                        text: "ราคาขายสินค้านี้ถูกบันทึกในระบบแล้ว!",
                        type: "warning"
                    });
                } else {
                    $('#modaladditem').modal('show');
                    $.get(
                            'index.php?r=Inventory/addnondrug/additemprice',
                            {
                                id: id
                            },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $('#from_additem').html(data);
                        $(".modal-title1").html("บันทึกราคาขาย");
                        $("#tbitemidprice-itemid").val(ItemID);
                        $("#tbitemprice-itemname").val(ItemName);
                        $("#tbitemprice-dispunit").val(DispUnit);
                    }
                    );
                }
            }
        });
    }

    /*   Query Table itemprice     */
    function Gettableitemprice() {
        var itemid = $("#tbitem-itemid").val();
        var edit = 'true';
        $.ajax({
            url: "index.php?r=Inventory/addnondrug/getitempriceedit",
            type: "post",
            data: {itemid: itemid, edit: edit}, dataType: "JSON",
            success: function (result) {
                $("#query_itemprice").html(result.table);
                $('#table_tb_itemid_price').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "bFilter": false,
                    "info": false,
                    "pageLength": 5,
                    "paging": false,
                    "bPaginate": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "No records available",
                        "search": "_INPUT_ ",
                        "sSearchPlaceholder": "ค้นหาข้อมูล",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    /* Edit ItemPrice */
    function UpdateItemprice(d) {
        var id = (d.getAttribute("data-id"));
        var date = (d.getAttribute("id"));
        $.get(
                "index.php?r=Inventory/addnondrug/additemprice",
                {
                    id: id, date: date
                },
        function (data)
        {
            $("#modaladditem").find(".modal-body").html(data);
            $("#from_additem").html(data);
            $(".modal-title1").html("แก้ไขข้อมูล");
            $("#modaladditem").modal("show");
        }
        );
    }

    /* Delete itemprice */
    function Deleteitemprice(d) {
        var id = (d.getAttribute("data-id"));
        var date = (d.getAttribute("id"));
        var edit = 'true';
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=Inventory/addnondrug/delete-itemprice',
                                {
                                    id: id, date: date
                                },
                        function (data)
                        {
                            Gettableitemprice();
                        }
                        );
                    }
                });
    }
</script>