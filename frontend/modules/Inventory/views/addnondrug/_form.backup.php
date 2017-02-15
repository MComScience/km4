<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
?>
<div class="well">
    <div class="tb-item-form">

        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'from_addnondrug', 'options' => ['enctype' => 'multipart/form-data'],]); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemID', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true,]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemNDMedSupplyCatID', ['label' => 'ประเภทเวชภัณฑ์' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                        $form->field($model, 'ItemNDMedSupplyCatID', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => yii\helpers\ArrayHelper::map(\app\models\TbItemndmedsupply::find()->all(), 'ItemNDMedSupplyCatID', 'ItemNDMedSupply'),
                            'pluginOptions' => [
                                'placeholder' => '--- Select Option ---',
                                'allowClear' => true
                            ],
                        ])->label();
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemName', ['label' => 'รายละเอียดสินค้า' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemName', ['showLabels' => false])->textarea(['style' => 'background-color: white', 'rows' => 3,]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemContVal', ['label' => 'ขนาดบรรจุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'itemContVal', ['showLabels' => false])->textInput(['style' => 'background-color: white',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemContUnit', ['label' => 'หน่วยของขนาดบรรจุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                        $form->field($model, 'itemContUnit', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => yii\helpers\ArrayHelper::map(\app\models\TbContunit::find()->all(), 'ContUnitID', 'ContUnit'),
                            'pluginOptions' => [
                                'placeholder' => '--- Select Option ---',
                                'allowClear' => true
                            ],
                        ])->label();
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemDispUnit', ['label' => 'หน่วยการจ่าย', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                        $form->field($model, 'itemDispUnit', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => yii\helpers\ArrayHelper::map(\app\models\TbDispunit::find()->all(), 'DispUnitID', 'DispUnit'),
                            'pluginOptions' => [
                                'placeholder' => '--- Select Option ---',
                                'allowClear' => true
                            ],
                        ])->label();
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itempBarcodeNum', ['label' => 'Item Barcode' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'itempBarcodeNum', ['showLabels' => false])->textInput(['style' => 'background-color: white',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemPic1', ['label' => 'ภาพสินค้า 1', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                        $form->field($model, 'ItemPic1', ['showLabels' => false])->widget(FileInput::classname(), [
                            'options' => ['multiple' => false, 'accept' => 'image/*'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'overwriteInitial' => true,
                                'initialPreviewShowDelete' => true,
                                'initialPreview' => $initialPreview,
                                'initialPreviewConfig' => $initialPreviewConfig,
                                // 'uploadExtraData' => [
                                //     'ref' => $model->ItemPic1,
                                // ],
                                'maxFileCount' => 1,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => 'Select Photo',
                            ]
                        ]);
                        ?>  

                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <br><br><br><br><br><br>
                <br><br><br><br>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemAutoLotNum', ['label' => 'ควบคุม Lot Number', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                                $form->field($model, 'ItemAutoLotNum', ['showLabels' => false])->radioList($model->getItemAutoLotNum(), ['inline' => true])
                                ->label()
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemExpDateControl', ['label' => 'เปลี่ยนสินค้าก่อนหมดอายุ(วัน)', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemExpDateControl', ['showLabels' => false])->textInput(['style' => 'background-color: white',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemMinOrderQty', ['label' => 'ปริมาณน้อยสุด/การสั่งซื้อ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemMinOrderQty', ['showLabels' => false])->textInput(['style' => 'background-color: white',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemMinOrderLeadtime', ['label' => 'ระยะเวลาในการจัดหา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'itemMinOrderLeadtime', ['showLabels' => false])->textInput(['style' => 'background-color: white',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemPic2', ['label' => 'ภาพสินค้า 2' , 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?=
                        $form->field($model, 'ItemPic2', ['showLabels' => false])->widget(FileInput::classname(), [
                            
                            'options' => ['multiple' => false, 'accept' => 'image/*'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'overwriteInitial' => true,
                                'initialPreviewShowDelete' => true,
                                'initialPreview' => $initialPreview1,
                                'initialPreviewConfig' => $initialPreviewConfig1,
                                // 'uploadExtraData' => [
                                //     'ref' => $model->ItemPic2,
                                // ],
                                'maxFileCount' => 1,
                                'browseClass' => 'btn btn-primary btn-block',
                                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => 'Select Photo',
                            ]
                        ]);
                        ?>  

                    </div>
                </div>
            </div>
        </div><!--/End Row -->
        <hr>
        <div class="row">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home1">
                            ขนาดแพค
                        </a>
                    </li>

                    <li class="tab-success">
                        <a data-toggle="tab" href="#profile">
                            ข้อมูลการจัดเก็บ
                        </a>
                    </li>
                    <li class="tab-success">
                        <a data-toggle="tab" href="#profile1">
                            ราคาขายสินค้า
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home1" class="tab-pane in active">
                        <?php if ($true == 'yes') { ?>
                            <a class="btn btn-success" id="บันทึกขนาดแพค"><i class="glyphicon glyphicon-plus"></i>บันทึกขนาดแพค</a>
                        <?php } ?>
                        <div id="query_itempack"></div>
                    </div>

                    <div id="profile" class="tab-pane">
                        <?php if ($true == 'yes') { ?>
                            <a class="btn btn-success" id="บันทึกข้อมูลการจัดเก็บ"><i class="glyphicon glyphicon-plus"></i>บันทึกข้อมูลการจัดเก็บ</a>
                        <?php } ?>
                        <div id="query_stklevel"></div>
                    </div>
                    <div id="profile1" class="tab-pane">
                        <?php if ($true == 'yes') { ?>
                            <a class="btn btn-success" id="บันทึกราคาขาย"><i class="glyphicon glyphicon-plus"></i>ราคาขาย</a>
                        <?php } ?>
                        <div id="query_itemprice"></div>
                    </div>

                </div>
            </div>
            <div class="horizontal-space"></div>
        </div><!--/End Row -->
    </div>
</div><!--/End Well -->
<div class="form-group" style="text-align: right">
    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
    <?php if ($true == 'yes') { ?>
        <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'บันทึกข้อมูลสินค้า') : Yii::t('app', 'บันทึกข้อมูลสินค้า'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php } ?>
</div>

<?php ActiveForm::end(); ?>


<!--/Modal บันทึก -->
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modaladditem',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
]);
?>
<div id="from_additem"></div>
<?php \yii\bootstrap\Modal::end(); ?>

<!--/Script -->
<?php if ($true == 'yes') { ?>
    <?php
    $script = <<< JS
$(function () {
/* บันทึกราคาขาย */
$('#บันทึกราคาขาย').click(function (e) {
    var ItemID = $("#tbitem-itemid").val();
    var ItemName = $("#tbitem-itemname").val();
    var id = '';
    var e = document.getElementById("tbitem-itemdispunit");
    var DispUnit = e.options[e.selectedIndex].text;
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
                    $(".modal-title").html("บันทึกราคาขาย");
                    $("#tbitemidprice-itemid").val(ItemID);
                    $("#tbitemprice-itemname").val(ItemName);
                    $("#tbitemprice-dispunit").val(DispUnit);
                }
                );
            }
        }
    });
});
        /* บันทึกขนาดแพค */
        $('#บันทึกขนาดแพค').click(function (e) {
            var ItemID = $("#tbitem-itemid").val();
            var ItemName = $("#tbitem-itemname").val();
            var id = '';
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            $('#modaladditem').modal('show');
            $.get(
                    'index.php?r=Inventory/addnondrug/additem-pack',
                    {
                        id: id
                    },
            function (data)
            {
                $("#modaladditem").find(".modal-body").html(data);
                $('#from_additem').html(data);
                $(".modal-title").html("บันทึกขนาดแพค");
                $("#tbitempack-itemid").val(ItemID);
                $("#tbitempack-itemname").val(ItemName);
                $("#tbitempack-dispunit").val(DispUnit);
                //$('#form_drugindication').trigger('reset');
            }
            );
        });
        /* บันทึกข้อมูลการจัดเก็บ */
        $('#บันทึกข้อมูลการจัดเก็บ').click(function (e) {
            var ItemID = $("#tbitem-itemid").val();
            var ItemName = $("#tbitem-itemname").val();
            var id = '';
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            $('#modaladditem').modal('show');
            $.get(
                    'index.php?r=Inventory/addnondrug/addstklevel',
                    {
                        id: id
                    },
            function (data)
            {
                $("#modaladditem").find(".modal-body").html(data);
                $('#from_additem').html(data);
                $(".modal-title").html("บันทึกข้อมูลการจัดเก็บ");
                $("#tbstklevelinfo-itemid").val(ItemID);
                $("#itemname").val(ItemName);
                $("#dispunit").val(DispUnit);
            }
            );
        });
    });
/*     */
$(document).ready(function () {
    GettableItempack();
    GettableStklevel();
    Gettableitemprice();
});
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'true';
    var e = document.getElementById("tbitem-itemdispunit");
    var DispUnit = e.options[e.selectedIndex].text;
    $.ajax({
        url: "index.php?r=Inventory/addnondrug/gettableitempack",
        type: "post",
        data: {itemid: itemid, edit: edit, DispUnit: DispUnit},
        dataType: "JSON",
        success: function (result) {
            $("#query_itempack").html(result.table);
            $('#table_tb_itempack').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                stateSave: true,
                "language": {
                    "lengthMenu": "_MENU_",
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
/*   Query Table stklevel     */
function GettableStklevel() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'true';
    $.ajax({
        url: "index.php?r=Inventory/addnondrug/gettablestklevel",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_stklevel").html(result.table);
            $('#table_tb_stk_levelinfo').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
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
/*   Query Table itemprice     */
        function Gettableitemprice() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            $.ajax({
                url: "index.php?r=Inventory/addnondrug/getitemprice",
                type: "post",
                data: {itemid: itemid, edit: edit}, dataType: "JSON",
                success: function (result) {
                    $("#query_itemprice").html(result.table);
                    $('#table_tb_itemid_price').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
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
JS;
    $this->registerJs($script, \yii\web\View::POS_END, 'additem');
    ?>
    <script>
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
                $(".modal-title").html("แก้ไขข้อมูล");
                $("#modaladditem").modal("show");
            }
            );
        }
        /* Edit ItemPack */
        function UpdateItempack(id) {
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            var ItemName = $("#tbitem-itemname").val();
            $.get(
                    "index.php?r=Inventory/addnondrug/additem-pack",
                    {
                        id: id,
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $("#tbitempack-dispunit").val(DispUnit);
                        $("#tbitempack-itemname").val(ItemName);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $("#modaladditem").modal("show");
                    }
            );
        }
        /* Edit StkLevel */
        function UpdateStklevel(d) {
            var id = (d.getAttribute("data-id"));
            var stkid = (d.getAttribute("id"));
            var ItemName = $("#tbitem-itemname").val();
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            $.get(
                    "index.php?r=Inventory/addnondrug/addstklevel",
                    {
                        id: id, id: id, stkid: stkid
                    },
            function (data)
            {
                $("#modaladditem").find(".modal-body").html(data);
                $("#from_additem").html(data);
                $(".modal-title").html("แก้ไขข้อมูล");
                $("#modaladditem").modal("show");
                $("#itemname").val(ItemName);
                $("#dispunit").val(DispUnit);
            }
            );
        }
        /* Delete สรรพคุณทางยา */
        function DeleteItempack(id) {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'index.php?r=Inventory/addnondrug/delete-itempack',
                                    {
                                        id: id
                                    },
                            function (data)
                            {
                                $.ajax({
                                    url: "index.php?r=Inventory/addnondrug/gettableitempack",
                                    type: "post",
                                    data: {itemid: itemid, edit: edit, DispUnit: DispUnit},
                                    dataType: "JSON",
                                    success: function (result) {
                                        $("#query_itempack").html(result.table);
                                        $('#table_tb_itempack').DataTable({
                                            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                            /* "paging": false, */
                                            "bFilter": false,
                                            "pageLength": 5,
                                            "language": {
                                                "lengthMenu": "_MENU_",
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
                            );
                        }
                    });
            //            bootbox.confirm('Are you sure?', function (result) {
            //                if (result) {

            //                }
            //            });
        }
        /* Delete Stklevel */
        function DeleteStklevel(d) {
            var id = (d.getAttribute("data-id"));
            var stk = (d.getAttribute("id"));
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'index.php?r=Inventory/addnondrug/delete-stklevel',
                                    {
                                        id: id, stk: stk
                                    },
                            function (data)
                            {
                                $.ajax({
                                    url: "index.php?r=Inventory/addnondrug/gettablestklevel",
                                    type: "post",
                                    data: {itemid: itemid, edit: edit},
                                    dataType: "JSON",
                                    success: function (result) {
                                        $("#query_stklevel").html(result.table);
                                        $('#table_tb_stk_levelinfo').DataTable({
                                            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                            /* "paging": false, */
                                            "bFilter": false,
                                            "pageLength": 5,
                                            "language": {
                                                "lengthMenu": "_MENU_",
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
                            );
                        }
                    });
            //            bootbox.confirm('Are you sure?', function (result) {
            //                if (result) {

            //                }
            //            });
        }
    </script>
<?php } ?>


<?php if ($true == 'view') { ?>
    <?php
    $script = <<< JS
/*     */
$(document).ready(function () {
    GettableItempack();
    GettableStklevel();
    Gettableitemprice();
});
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'false';
    $.ajax({
        url: "index.php?r=Inventory/addnondrug/gettableitempack",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_itempack").html(result.table);
            $('#table_tb_itempack').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "language": {
                    "lengthMenu": "_MENU_",
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
/*   Query Table stklevel     */
function GettableStklevel() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'false';
    $.ajax({
        url: "index.php?r=Inventory/addnondrug/gettablestklevel",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_stklevel").html(result.table);
            $('#table_tb_stk_levelinfo').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
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
/*   Query Table itemprice     */
        function Gettableitemprice() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'false';
            $.ajax({
                url: "index.php?r=Inventory/addnondrug/getitemprice",
                type: "post",
                data: {itemid: itemid, edit: edit}, dataType: "JSON",
                success: function (result) {
                    $("#query_itemprice").html(result.table);
                    $('#table_tb_itemid_price').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
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
JS;
    $this->registerJs($script, \yii\web\View::POS_END, 'additem');
    ?>
<?php } ?>
