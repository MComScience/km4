<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
//use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
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

// print_r((isset($dataProvider)?$dataProvider:''));
$this->registerJs('$("#tab_A").addClass("active");');

$sort ='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
.'<label><input name="Chk1" id="Chk1" type="checkbox"  /><span class="text"></span>ยาการค้า&nbsp;</label>'
. '<label><input name="Chk2" id="Chk2" type="checkbox" /><span class="text"></span>เวชภัณฑ์มิใช่ยา&nbsp;</label>'
. '<label><input name="Chk3" id="Chk3" type="checkbox" /><span class="text"></span>วัสดุการแพทย์&nbsp;</label>'
. '<label><input name="Chk4" id="Chk4" type="checkbox" /><span class="text"></span>งานจ่ายกลาง&nbsp;</label>'
. '<label><input name="Chk5" id="Chk5" type="checkbox" /><span class="text"></span>วัสดุวิทยาศาสตร์&nbsp;</label>'
. '<label><input name="Chk6" id="Chk6" type="checkbox" /><span class="text"></span>งานพัสดุ&nbsp;</label>'
. '<span>&nbsp;</span>'
;

$btnprint = '<div class="btn-group">
<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100"><i class="glyphicon glyphicon-export"></i><b class="caret"></b></a>
<ul class="dropdown-menu">
    <li>
        <a href="/km4/Inventory/dashboard-v2/export-pdf&type=1" target="_blank" data-pjax="0"><i class="text-danger fa fa-file-pdf-o"></i> PDF</a>
    </li>
    <li>
        <a href="/km4/Inventory/dashboard-v2/export-excel&type=1" target="_blank" data-pjax="0"><i class="text-success fa fa-file-excel-o"></i> Excel</a>
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
<input type="hidden"  id="ItemID">
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tabnew'); ?>
            <div class="tab-content"><div class="well">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12" >
                            <?php Pjax::begin(); ?> 
                            <?php echo $this->render('_search-datatable', ['model' => $model]); ?>
                            <?php if(isset($dataProvider)) :?>
                                <!-- DATATABLE -->
                                <?=
                                fedemotta\datatables\DataTables::widget([
                                    'dataProvider' => $dataProvider,
                                    'tableOptions' => [
                                    'class' => 'default kv-grid-table 
                                                table table-hover table-bordered  
                                                table-condensed',
                                    ],
                                    'options' => [
                                    'retrieve' => true
                                    ],
                                    'clientOptions' => [
                                    'bSortable' => false,
                                    'bAutoWidth' => true,
                                    'ordering' => true,
                                    'pageLength' => 40,
                                    'bFilter' => true,
                                    'language' => [

                                    'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                    'lengthMenu' => '_MENU_',
                                    'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                    'search' => '_INPUT_' . $sort
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
                                    'headerOptions' => ['style' => 'color:black;text-align:center;width: 130px;', 'noWrap' => true,],
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
                                    'attribute' => 'StkBalance',
                                    'contentOptions' => ['style' => 'text-align:right;'],
                                    'options' => ['style' => 'background-color: #d9edf7'],
                                    'format' => ['decimal', 2],
                                    'value' => function ($model) {
                                        return empty($model['StkBalance']) ? '' : $model['StkBalance'];
                                    }
                                    ],

                                    [
                                    'header' => 'หน่วย',
                                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3;width: 70px;', 'noWrap' => true,],
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
                                    'stockcard' => function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span>', '#', 
                                            [
                                            'title' => 'stockcard',
                                            'onclick' => 'selectdetail(this);',
                                            'stkid' => $model['StkID'],
                                            'itemid' => $model['ItemID'],
                                            // 'class' => 'activity-stockcard-link',
                                            ]);
                                        },
                                        ],

                                    ],
                                ],
                                    ]);
                                    ?>
<script>
    function  selectdetail(e) {
        var itemid = e.getAttribute('itemid');
        var stkid = e.getAttribute('stkid');
        $.fn.dataTable.ext.search.pop();
        $.ajax({
            url: 'view-stockcard',
            type: 'POST',
            data: {itemid: itemid, stkid: stkid},
            dataType: 'json',
            success: function (data) {
                $('#_result').html(data.html);
                $('#itemid').html(data.itemid);
                $('#itemname').html(data.itemname);
                $('#tpu_sr2_detail_list').modal('show');
                
                $('#stkcard').DataTable({
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
<!-- EndStockCard -->
<?php
$script = <<< JS
$(document).ready(function () {
    var table = $('#datatables_w1').DataTable();

    $("input[id=Chk1]").click(function () {
        if ($(this).is(':checked')) { 
            chk_swap("1");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^1.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        }else{
            pop();
        }
    });

    $("input[id=Chk2]").click(function () {
        if ($(this).is(':checked')) {
            chk_swap("2");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^2.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        } else {
            pop();
        }
    });

    $("input[id=Chk3]").click(function () {
        if ($(this).is(':checked')) {
            chk_swap("3");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^3.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        } else {
            pop();
        }
    });

    $("input[id=Chk4]").click(function () {
        if ($(this).is(':checked')) {
           chk_swap("4");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^4.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        } else {
            pop();
        }
    });

    $("input[id=Chk5]").click(function () {
        if ($(this).is(':checked')) {
            chk_swap("5");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^5.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        } else {
            pop();
        }
    });

    $("input[id=Chk6]").click(function () {
        if ($(this).is(':checked')) {
            chk_swap("6");
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var age = data[2] || 0;
                    if (age.match(/^6.*$/))
                    {
                        return true;
                    }
                    return false;
                }
                );
                table.draw();
        } else {
            pop();
        }
    });
});	
	
	function pop(){
		$.fn.dataTable.ext.search.pop();
       	var newTable = $('#datatables_w1').DataTable();
        newTable.draw();
    }
	function chk_swap(id) {
        if(id){
             for (i = 1; i <=6; i++) {
              if(i != id){
                var Element_id = "Chk"+i;
                document.getElementById(Element_id).checked = false;
              }
            }
            pop();
        }else{
            console.log('Error function');
        }
    }
JS;
$this->registerJs($script);
?>
                            <?php Pjax::end(); ?>
                                <?php else : ?>
                                    <!-- END_DATATABLE -->
<!-- TABLE_INPUT -->
<style type="text/css">
    table.default th{
        text-align: center;
    }
</style>
<table class="default kv-grid-table table table-hover table-bordered  table-condensed dataTable no-footer" width="100%" style="margin-left: 7px;">
    <thead>
        <tr >
            <th>
                #
            </th>
            <th>
                คลังสินค้า
            </th>
            <th>
                รหัสสินค้า
            </th>
            <th>
                รายละเอียดสินค้า
            </th>
            <th style="background-color: #d9edf7">
                ยอดคงคลัง
            </th>
            <th style="background-color: #fcf8e3">
                หน่วย
            </th>
            <th>
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        <td colspan="7" style="text-align: center;">No matching records found</td>
    </tbody>
</table>
<!-- END_TABLE_INPUT -->

                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row" style="margin-right: -7px;">
                            <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: right;" >
                                <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>

<!-- StockCard -->



<!-- CheckBox -->
<!-- <script>
    function check(vol) {
        if(vol.checked == true){
            document.getElementById("Chk1").checked = true;
        }else{
            document.getElementById("Chk2").checked = false;
            document.getElementById("Chk3").checked = false;
            document.getElementById("Chk4").checked = false;
            document.getElementById("Chk5").checked = false;
            document.getElementById("Chk6").checked = false;
        }
    }
</script> -->
<!--End CheckBox -->

</body>
</html>
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