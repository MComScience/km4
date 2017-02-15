<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use frontend\assets\WaitMeAsset;
use frontend\assets\ScriptCamAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\AutoNumericAsset;

WaitMeAsset::register($this);
ScriptCamAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
AutoNumericAsset::register($this);
?>
<?= yii2mod\alert\Alert::widget() ?>
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
                            'data' => yii\helpers\ArrayHelper::map(\app\models\TbItemndmedsupply::find()->where(['ItemNDMedSupplyCatID_sub' => ['10', '11', '12']])->all(), 'ItemNDMedSupplyCatID', 'ItemNDMedSupply'),
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
                        <?= $form->field($model, 'ItemName', ['showLabels' => false])->textarea(['style' => 'background-color: #ffff99', 'rows' => 3,]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemContVal', ['label' => 'ขนาดบรรจุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'itemContVal', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
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
                        <?= $form->field($model, 'itempBarcodeNum', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 1</label>
                    <div class="col-sm-7">
                        <div id="webcam1"></div>
                        <p><img id="image1" src="<?php echo!empty($model->ItemPic1) ? Yii::getAlias('@web') . '/' . $model->ItemPic1 : ''; ?>" /></p>
                        <a class="btn btn-small btn-success"  id="btnshowcamera1" onclick="showwebcam(1)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a>  <a class="btn btn-small btn-danger" onclick="btndeleteimg(1)"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-small btn-success hidden" id="btntakesnapimg1" onclick="base64_toimage(1)">ถ่ายภาพ</a>
                        <input type="hidden" id="tbitem-itempic1" name="TbItem[ItemPic1]" value="<?php echo $model->ItemPic1; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 3</label>
                    <div class="col-sm-7">
                        <div id="webcam3"></div>
                        <p><img id="image3" src="<?php echo!empty($model->ItemPic3) ? Yii::getAlias('@web') . '/' . $model->ItemPic3 : ''; ?>" /></p>
                        <a class="btn btn-small btn-success"  id="btnshowcamera3" onclick="showwebcam(3)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> 
                        <a class="btn btn-small btn-danger" onclick="btndeleteimg(3)"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-small btn-success hidden" id="btntakesnapimg3" onclick="base64_toimage(3)">ถ่ายภาพ</a>
                        <input type="hidden" id="tbitem-itempic3" name="TbItem[ItemPic3]" value="<?php echo $model->ItemPic3; ?>"/>
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
                        $form->field($model, 'ItemAutoLotNum', ['showLabels' => false])->radioList($model->getItemAutoLotNum(), ['inline' => true, 'item' => function($index, $label, $name, $checked, $value) {
                                $check = $checked ? ' checked="checked"' : '';
                                $return = '<label class="modal-radio">';
                                $return .= '<input type="radio"  ' . $check . ' name="' . $name . '" value="' . $value . '" tabindex="3">';
                                $return .= '<i></i>';
                                $return .= '<span class="text">' . ucwords($label) . '</span>';
                                $return .= '</label>';

                                return $return;
                            }]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemExpDateControl', ['label' => 'เปลี่ยนสินค้าก่อนหมดอายุ(วัน)', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemExpDateControl', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'ItemMinOrderQty', ['label' => 'ปริมาณน้อยสุด/การสั่งซื้อ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'ItemMinOrderQty', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'itemMinOrderLeadtime', ['label' => 'ระยะเวลาในการจัดหา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                    <div class="col-sm-7">
                        <?= $form->field($model, 'itemMinOrderLeadtime', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 2</label>
                    <div class="col-sm-7">
                        <div id="webcam2"></div>
                        <p><img id="image2" src="<?php echo!empty($model->ItemPic2) ? Yii::getAlias('@web') . '/' . $model->ItemPic2 : ''; ?>" /></p>
                        <a class="btn btn-small btn-success"  id="btnshowcamera2" onclick="showwebcam(2)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> 
                        <a class="btn btn-small btn-danger" onclick="btndeleteimg(2)"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-small btn-success hidden" id="btntakesnapimg2" onclick="base64_toimage(2)">ถ่ายภาพ</a>
                        <input type="hidden" id="tbitem-itempic2" name="TbItem[ItemPic2]" value="<?php echo $model->ItemPic2; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 4</label>
                    <div class="col-sm-7">
                        <div id="webcam4"></div>
                        <p><img id="image4" src="<?php echo!empty($model->ItemPic4) ? Yii::getAlias('@web') . '/' . $model->ItemPic4 : ''; ?>" /></p>
                        <a class="btn btn-small btn-success"  id="btnshowcamera4" onclick="showwebcam(4)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> 
                        <a class="btn btn-small btn-danger" onclick="btndeleteimg(4)"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-small btn-success hidden" id="btntakesnapimg4" onclick="base64_toimage(4)">ถ่ายภาพ</a>
                        <input type="hidden" id="tbitem-itempic4" name="TbItem[ItemPic4]" value="<?php echo $model->ItemPic4; ?>"/>
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
                        <hr>
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
        LoadingClass();
        $.ajax({
            url: "/km4/Inventory/addnondrug/checkitemidprice",
            type: "post",
            data: {ItemID: ItemID},
            dataType: "JSON",
            success: function (result) {
                if (result != null) {
                    $('.page-content').waitMe('hide');
                    swal({
                        title: "",
                        text: "ราคาขายสินค้านี้ถูกบันทึกในระบบแล้ว!",
                        type: "warning"
                    });
                } else {

                    $.get(
                            '/km4/Inventory/addnondrug/additemprice',
                            {
                                id: id
                            },
                            function (data)
                            {
                                $("#modaladditem").find(".modal-body").html(data);
                                $('#from_additem').html(data);
                                $(".modal-title").html("บันทึกราคาขาย");
                                $('.page-content').waitMe('hide');
                                $('#modaladditem').modal('show');
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
        LoadingClass();
        $.get(
                '/km4/Inventory/addnondrug/additem-pack',
                {
                    id: id
                },
                function (data)
                {
                    $("#modaladditem").find(".modal-body").html(data);
                    $('#from_additem').html(data);
                    $(".modal-title").html("บันทึกขนาดแพค");
                    $('.page-content').waitMe('hide');
                    $('#modaladditem').modal('show');
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
        LoadingClass();
        $.get(
                '/km4/Inventory/addnondrug/addstklevel',
                {
                    id: id
                },
                function (data)
                {
                    $("#modaladditem").find(".modal-body").html(data);
                    $('#from_additem').html(data);
                    $(".modal-title").html("บันทึกข้อมูลการจัดเก็บ");
                    $('.page-content').waitMe('hide');
                    $('#modaladditem').modal('show');
                    $("#tbstklevelinfo-itemid").val(ItemID);
                    $("#itemname").val(ItemName);
                    $("#dispunit").val(DispUnit);
                }
        );
    });
});
$('#แก้ไขราคาตามสิทธิ์การรักษา').click(function (e) {
    var ItemID = $("#tbitem-itemid").val();
    var itemname = $("#tbitem-itemname").val();
    LoadingClass();
    $.ajax({
        url: "/km4/Inventory/additem/checkitemidprice",
        type: "post",
        data: {ItemID: ItemID},
        dataType: "JSON",
        success: function (result) {
            if (result == null) {
                $('.page-content').waitMe('hide');
                swal({
                    title: "",
                    text: "กรุณาบันทึกราคาขาย!",
                    type: "warning"
                });
            } else {

                $.get(
                        '/km4/Inventory/additem/addcredit-price-item',
                        {
                            id: ItemID
                        },
                        function (data)
                        {
                            $("#modaladditem").find(".modal-body").html(data);
                            $('#from_additem').html(data);
                            $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
                            $('.page-content').waitMe('hide');
                            $('#modaladditem').modal('show');
                            $("#vwitempricelistscl-itemid").val(ItemID);
                            $("#vwitempricelistscl-itemname").val(itemname);
                        }
                );
            }
        }
    });
});
/*     */
$(document).ready(function () {
    GettableItempack();
    GettableStklevel();
    Gettableitemprice();
    Gettablecredititem();
});

function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'true';
    var e = document.getElementById("tbitem-itemdispunit");
    var DispUnit = e.options[e.selectedIndex].text;
    $.ajax({
        url: "/km4/Inventory/addnondrug/gettableitempack",
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
        url: "/km4/Inventory/addnondrug/gettablestklevel",
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
                url: "/km4/Inventory/addnondrug/getitemprice",
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
            
/* เบิกได้ตามสิทธิ์การรักษา */
/*
$('#เบิกได้ตามสิทธิ์การรักษา').click(function (e) {
    var ItemID = $("#tbitem-itemid").val();
    var FSN_GPU = $("#tbitem-itemname").val();
    var id = '';
    var e = document.getElementById("tbitem-itemdispunit");
    var DispUnit = e.options[e.selectedIndex].text;
    $('#modaladditem').modal('show');
    $.get(
            '/km4/Inventory/additem/addcredititem',
            {
                id: id
            },
    function (data)
    {
        $("#modaladditem").find(".modal-body").html(data);
        $('#from_additem').html(data);
        $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
        $("#tbcredititem-itemid").val(ItemID);
        $("#tbitemprice-itemname").val(FSN_GPU);
        $("#tbitemprice-dispunit").val(DispUnit);
    }
    );
});

*/
/* เบิกได้ตามสิทธิ์การรักษา */
$('#เบิกได้ตามสิทธิ์การรักษา').click(function (e) {
    var ItemID = $("#tbitem-itemid").val();
    var itemname = $("#tbitem-itemname").val();
    LoadingClass();
    $.ajax({
        url: "/km4/Inventory/additem/checkitemidprice",
        type: "post",
        data: {ItemID: ItemID},
        dataType: "JSON",
        success: function (result) {
            if (result == null) {
                $('.page-content').waitMe('hide');
                swal({
                    title: "",
                    text: "กรุณาบันทึกราคาขาย!",
                    type: "warning"
                });
            } else {
                
                $.get(
                        '/km4/Inventory/additem/addcredit-price-item',
                        {
                            id: ItemID
                        },
                function (data)
                {
                    $("#modaladditem").find(".modal-body").html(data);
                    $('#from_additem').html(data);
                    $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
                    $('.page-content').waitMe('hide');
                    $('#modaladditem').modal('show');
                    $("#vwitempricelistscl-itemid").val(ItemID);
                    $("#vwitempricelistscl-itemname").val(itemname);
                }
                );
            }
        }
    });
});
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
                                    '/km4/Inventory/addnondrug/delete-itemprice',
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
            LoadingClass();
            $.get(
                    "/km4/Inventory/addnondrug/additemprice",
                    {
                        id: id, date: date
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $('.page-content').waitMe('hide');
                        $("#modaladditem").modal("show");
                    }
            );
        }
        /* Edit ItemPack */
        function UpdateItempack(id) {
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            var ItemName = $("#tbitem-itemname").val();
            LoadingClass();
            $.get(
                    "/km4/Inventory/addnondrug/additem-pack",
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
                        $('.page-content').waitMe('hide');
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
            LoadingClass();
            $.get(
                    "/km4/Inventory/addnondrug/addstklevel",
                    {
                        id: id, id: id, stkid: stkid
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $('.page-content').waitMe('hide');
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
                                    '/km4/Inventory/addnondrug/delete-itempack',
                                    {
                                        id: id
                                    },
                                    function (data)
                                    {
                                        $.ajax({
                                            url: "/km4/Inventory/addnondrug/gettableitempack",
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
                                    '/km4/Inventory/addnondrug/delete-stklevel',
                                    {
                                        id: id, stk: stk
                                    },
                                    function (data)
                                    {
                                        $.ajax({
                                            url: "/km4/Inventory/addnondrug/gettablestklevel",
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
        }

        /*   Query Table credititem     */
        function Gettablecredititem() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            $.ajax({
                url: "/km4/Inventory/additem/getcredititem",
                type: "post", data: {itemid: itemid, edit: edit},
                dataType: "JSON",
                success: function (result) {
                    $("#query_credititem").html(result.table);
                    $('#table_tb_credititem').DataTable({
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

        /* Edit Credititem*/
        function UpdateCredititem(d) {
            var id = (d.getAttribute("data-id"));
            var maininscl_id = (d.getAttribute("id"));
            $.get(
                    "/km4/Inventory/additem/addcredititem",
                    {
                        id: id, maininscl_id: maininscl_id
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

        /* Delete Credititem */
        function DeleteCredititem(d) {
            var id = (d.getAttribute("data-id"));
            var maininscl_id = (d.getAttribute("id"));
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
                                    '/km4/Inventory/additem/delete-credititem',
                                    {
                                        id: id, maininscl_id: maininscl_id
                                    },
                                    function (data)
                                    {
                                        Gettablecredititem();
                                    }
                            );
                        }
                    });
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
    Gettablecredititem();
});
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'false';
    $.ajax({
        url: "/km4/Inventory/addnondrug/gettableitempack",
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
        url: "/km4/Inventory/addnondrug/gettablestklevel",
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
                url: "/km4/Inventory/addnondrug/getitemprice",
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
           
/*   Query Table credititem     */
        function Gettablecredititem() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'false';
            $.ajax({
                url: "/km4/Inventory/additem/getcredititem",
                type: "post", data: {itemid: itemid, edit: edit},
                dataType: "JSON",
                success: function (result) {
                    $("#query_credititem").html(result.table);
                    $('#table_tb_credititem').DataTable({
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
<script>
    function showwebcam(type) {
        if (type == '1') {
            var id = "#webcam1";
            $('#btntakesnapimg1').removeClass('hidden');
            $('#btnshowcamera1').addClass('hidden');

        } else if (type == '2') {
            var id = "#webcam2";
            $('#btntakesnapimg2').removeClass('hidden');
            $('#btnshowcamera2').addClass('hidden');
        } else if (type == '3') {
            var id = "#webcam3";
            $('#btntakesnapimg3').removeClass('hidden');
            $('#btnshowcamera3').addClass('hidden');
        } else if (type == '4') {
            var id = "#webcam4";
            $('#btntakesnapimg4').removeClass('hidden');
            $('#btnshowcamera4').addClass('hidden');
        }
        $(id).scriptcam({
            showMicrophoneErrors: false,
            onError: onError,
            cornerRadius: 20,
            cornerColor: 'e3e5e2',
            onWebcamReady: onWebcamReady,
            // uploadImage: 'upload.gif',
            onPictureAsBase64: base64_tofield_and_image
        });


    }
    function base64_tofield() {
        $('#formfield').val($.scriptcam.getFrameAsBase64());
    }
    ;
    function base64_toimage(type) {
        var ima = "data:image/png;base64," + $.scriptcam.getFrameAsBase64();
        if (type == '1') {

            $.ajax({
                url: "/km4/Report/report-purchasing/saveimage",
                type: "post",
                data: {im: ima},
                success: function (result) {
                    $('#image1').attr("src", '/km4/' + result);
                    $("#webcam1").replaceWith("<div id='webcam1'></div>");
                    $('#btntakesnapimg1').addClass('hidden');
                    $('#tbitem-itempic1').val(result);
                    $('#btnshowcamera1').removeClass('hidden');
                }
            });
        } else if (type == '2') {
            $.ajax({
                url: "/km4/Report/report-purchasing/saveimage",
                type: "post",
                data: {im: ima},
                success: function (result) {
                    $('#image2').attr("src", '/km4/' + result);
                    $("#webcam2").replaceWith("<div id='webcam2'></div>");
                    $('#btntakesnapimg2').addClass('hidden');
                    $('#tbitem-itempic2').val(result);
                    $('#btnshowcamera2').removeClass('hidden');
                }
            });
        } else if (type == '3') {
            $.ajax({
                url: "/km4/Report/report-purchasing/saveimage",
                type: "post",
                data: {im: ima},
                success: function (result) {
                    $('#image3').attr("src", '/km4/' + result);
                    $("#webcam3").replaceWith("<div id='webcam3'></div>");
                    $('#btntakesnapimg3').addClass('hidden');
                    $('#tbitem-itempic3').val(result);
                    $('#btnshowcamera3').removeClass('hidden');
                }
            });
        } else if (type == '4') {
            $.ajax({
                url: "/km4/Report/report-purchasing/saveimage",
                type: "post",
                data: {im: ima},
                success: function (result) {
                    $('#image4').attr("src", '/km4/' + result);
                    $("#webcam4").replaceWith("<div id='webcam4'></div>");
                    $('#btntakesnapimg4').addClass('hidden');
                    $('#tbitem-itempic4').val(result);
                    $('#btnshowcamera4').removeClass('hidden');
                }
            });
        }
    }
    ;
    function base64_tofield_and_image(b64) {
        $('#formfield').val(b64);
        $('#image').attr("src", "data:image/png;base64," + b64);
    }
    ;
    function changeCamera() {
        $.scriptcam.changeCamera($('#cameraNames').val());
    }
    function onError(errorId, errorMsg) {
        $("#btn1").attr("disabled", true);
        $("#btn2").attr("disabled", true);
        alert(errorMsg);
    }
    function onWebcamReady(cameraNames, camera, microphoneNames, microphone, volume) {
        $.each(cameraNames, function (index, text) {
            $('#cameraNames').append($('<option></option>').val(index).html(text))
        });
        $('#cameraNames').val(camera);
    }
    function btndeleteimg(type) {
        if (type == '1') {
            var imgsrc = $("#image1").attr('src');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "/km4/Report/report-purchasing/deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc},
                                success: function (result) {
                                    $('#image1').attr("src", '');
                                    $('#tbitem-itempic1').val(null);
                                }
                            });
                        } else {

                        }
                    });
        } else if (type == '2') {
            var imgsrc = $("#image2").attr('src');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "/km4/Report/report-purchasing/deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc},
                                success: function (result) {
                                    $('#image2').attr("src", '');
                                    $('#tbitem-itempic2').val(null);
                                }
                            });
                        } else {

                        }
                    });
        } else if (type == '3') {
            var imgsrc = $("#image3").attr('src');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "/km4/Report/report-purchasing/deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc},
                                success: function (result) {
                                    $('#image3').attr("src", '');
                                    $('#tbitem-itempic3').val(null);
                                }
                            });
                        } else {

                        }
                    });
        } else if (type == '4') {
            var imgsrc = $("#image4").attr('src');

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "/km4/Report/report-purchasing/deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc},
                                success: function (result) {
                                    $('#image4').attr("src", '');
                                    $('#tbitem-itempic4').val(null);
                                }
                            });
                        } else {

                        }
                    });
        }
    }
</script>
