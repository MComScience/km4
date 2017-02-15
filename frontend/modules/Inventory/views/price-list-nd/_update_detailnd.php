<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
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
//echo $QUAttachmentPath;
?>
<?php
$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formpricelistnd',
    'options' => ['enctype' => 'multipart/form-data'],
    ]);
?>
<div class="well">
    <div class="row">
        <div class="col-xs-6">
           <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รหัสสินค้า</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'TMTID_TPU', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white',
                        'value' => $ItemID
                    ])
                    ?>
                </div> 
            </div>
           <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดสินค้า</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeltbitempricelist, 'ItemName', ['showLabels' => false])->textarea([
                        'rows' => 6,
                        'readonly' => true,
                        'style' => 'background-color:white',
                        'value' => $ItemName,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดเพิ่มเติม<p>หรือข้อเสนอการค้า</p><a id="checkหมายเหตุ"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUComment', ['showLabels' => false])->textarea([
                        'rows' => 3,
                        'readonly' => true,
                        'style' => 'background-color:white',
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">คุณสมบัติเฉพาะ1<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listFiles1('QUAttach1') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadFiles1('QUAttach1') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">คุณสมบัติเฉพาะ2<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listFiles2('QUAttach2') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadFiles2('QUAttach2') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" style="padding-top: 0px !important;">คุณสมบัติเฉพาะ3<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listFiles3('QUAttach3') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadFiles3('QUAttach3') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" style="padding-top: 0px !important;">คุณสมบัติเฉพาะ4<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listFiles4('QUAttach4') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadFiles4('QUAttach4') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ภาพสินค้า(ด้านหน้า)<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listPic1('QUPic1') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadPic1('QUPic1') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ภาพสินค้า(ด้านหลัง)<a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listPic2('QUPic2') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadPic2('QUPic2') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ภาพบรรจุภัณฑ์<p>(ด้านหน้า)</p><a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listPic3('QUPic3') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadPic3('QUPic3') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ภาพบรรจุภัณฑ์<p>(ด้านหลัง)</p><a id="checkไฟล์แนบ"></a></label>
                <div class="col-sm-8">
                   <input type="text" readonly="" class="form-control"  name="" id="" value="<?php echo $model->listPic4('QUPic4') ?>"/>
                </div>
                <div style="text-align: right;margin-right: 15px">
                     <?php echo $model->listDownloadPic4('QUPic4') ?>
<!--                  <button class="btn btn-danger btn-xs" >Delete</button>
                    <button class="btn btn-success btn-xs">Select</button>-->
                   
                </div>
            </div>
           
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right"></label>
                <div class="col-sm-8">
                <div class="radio">
                    <label><input type="radio" name="แพค" id="แพค" value="yes"/> <span class="text">แพค  </span></label>
                    <label><input type="radio"  name="แพค" id="ชิ้น" value="no"/> <span class="text">ชิ้น  </span></label>
                    </div>
                    <!--                แพค <input type="radio" id="แพค" class="inverted" name="แพค" value="Yes" /> 
                                    ชิ้น <input type="radio" id="ชิ้น" class="inverted" name="ชิ้น" value="No" checked=""/> -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($modeledit['QUPackQty'], 2),
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modelpack, 'PackUnitID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณต่อแพค<a id="checkปริมาณต่อแพค"></a></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="ItemPackSKUQty" readonly="" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($ItemPackSKUQty == null) {
                               echo '0.00';
                           } else {
                               echo number_format($ItemPackSKUQty,2);
                           }
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อแพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUPackCost', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['QUPackCost'], 4),
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">จำนวน<a id="checkขอซื้อ"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUOrderQty', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['QUOrderQty'], 2),
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUUnitCost', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['QUUnitCost'], 4),
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วย<a id="checkUnit"></a></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemUnit" name="ItemUnit" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($ItemUnit == null) {
                               echo 'ไม่มีหน่วย';
                           } else {
                               echo $ItemUnit;
                           }
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">รวมเป็นเงิน</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="QUExtenedCost" name="QUExtenedCost" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($QUExtenedCost == null) {
                               echo '0.0000';
                           } else {
                               echo number_format($QUExtenedCost,4);
                           }
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">MinOderQty <a id="checkMinOderQty"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'QUMQO', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['QUMQO'], 2),
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">เวลาในการจัดส่ง(วัน)<a id="checkเวลาในการจัดส่ง"></a></label>
                <div class="col-sm-8">
                     <?=
                    $form->field($modeledit, 'QULeadtime', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true,
                        //'value' => $QULeadtime,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ยืนยันราคาถึงวันที่<a id="checkยืนยันราคาถึงวันที่"></a></label>
                <div class="col-sm-8">
                   <?=
                     $form->field($modeledit, 'QUValidDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                            'language' => 'th',
                            'dateFormat' => 'dd/MM/yyyy',
                            'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                                ],
                                   'options' => [
                                   'class' => 'form-control',
                                   'style' => 'background-color: white'
                                ],
                     ])
                   ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ผู้จัดจำหน่าย <a id="checkdis"></a></label>
                <div class="col-sm-8">
                <?php 
                $findVendorID = \app\modules\Purchasing\models\VwVendorList::findOne(['VendorID'=>$modeledit['distributor_id']]);
                $Vender_name = $findVendorID['VenderName'];
                ?>
                <?= 
                    $form->field($modeledit, 'distributor_id', ['showLabels' => false])->textInput([
                        'value' =>$Vender_name,
                        'style' => 'background-color: white;text-align:left',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>
        </div>
        <input type="hidden" class="form-control" name="checkpackunit" id="checkpackunit" value="<?php echo $PackUnit; ?>"/>
        <input type="hidden" class="form-control" name="QUAttachmentPath" id="QUAttachmentPath" value="<?php echo $QUAttachmentPath; ?>"/>
        <input type="hidden" class="form-control" name="ids_qu" id="ids_qu" value="<?php echo $ids_qu; ?>"/>
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
<!--                <button class="btn btn-success" type="submit">Save</button>-->
               
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<!--JSScript/-->
<?php
$script = <<< JS
$(document).ready(function () {
    $('#w0 img').width('100px');
    $('#w0 img').height('100px');
    var checkpackunit = $("#checkpackunit").val();
    if(checkpackunit == '' || checkpackunit == '0'){
        document.getElementById("ชิ้น").checked = true;
//        $("#checkขอซื้อ,#checkราคาต่อหน่วย").html('<font color="red">*</font>');
//        $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").attr('readonly', 'readonly');
//        $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").removeAttr('readonly');
//        $("#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค").html('');
//        $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', '#FFFF99');
//        $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', 'white');  
    }else{
        document.getElementById("แพค").checked = true;
        $("#tbpackunit-packunitid").val(checkpackunit).trigger("change");
//        $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").removeAttr('readonly');
//        $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").attr('readonly', 'readonly');
//        $("#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค").html('<font color="red">*</font>');
//        $("#checkขอซื้อ,#checkราคาต่อหน่วย").html('');
//        $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', '#FFFF99');
//        $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', 'white');
    }
//    $('#checkหมายเหตุ,#checkไฟล์แนบ,#checkเวลาในการจัดส่ง,#checkยืนยันราคาถึงวันที่,#checkMinOderQty').html('<font color="red">*</font>');
//    $("#tbqupricelist-quleadtime,#tbqupricelist-quvaliddate,#tbqupricelist-qumqo,#tbqupricelist-quattachment,#tbqupricelist-qucomment").css('background-color', '#FFFF99');    
////---------------------------------START Unit/Pack-------------------    
//   if ($("input[id=ชิ้น]").is(":checked")){
//                $("#checkขอซื้อ,#checkราคาต่อหน่วย").html('<font color="red">*</font>');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").attr('readonly', 'readonly');
//                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").removeAttr('readonly');
//                $("#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค").html('');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', '#FFFF99');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', 'white');  
//        }else if ($("input[id=แพค]").is(":checked")){
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").removeAttr('readonly');
//                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").attr('readonly', 'readonly');
//                $("#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค").html('<font color="red">*</font>');
//                $("#checkขอซื้อ,#checkราคาต่อหน่วย").html('');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', '#FFFF99');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', 'white');
//        }$("input[id=แพค]").click(function () {
//        if ($(this).is(":checked"))
//        {       
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").removeAttr('readonly');
//                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").attr('readonly', 'readonly');
//                $("#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค").html('<font color="red">*</font>');
//                $("#checkขอซื้อ,#checkราคาต่อหน่วย").html('');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', '#FFFF99');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', 'white');
//        }
//        });
//        $("input[id=ชิ้น]").click(function () {
//        if ($(this).is(":checked"))
//        {
//                $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").attr('readonly', 'readonly');
//                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").removeAttr('readonly');
//                $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณต่อแพค').html('');
//                $("#tbqupricelist-quorderqty,#tbqupricelist-quunitcost").css('background-color', '#FFFF99');
//                $("#tbqupricelist-qupackqty,#ItemPackSKUQty,#tbqupricelist-qupackcost").css('background-color', 'white');   
//        }
//        });    
});
////--------------------------------END Unit/Pack------------------- 
////--------------------------------START Calculate-----------------
////Calculate PackQty    
//$("#tbqupricelist-qupackqty").keyup(function () {
//        $('input[id="tbqupricelist-qupackqty"]').priceFormat({prefix: ''});
//        var uni = parseFloat($("#tbqupricelist-qupackqty").val().replace(/[,]/g, ""));
//        var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
//        var unitcost = parseFloat($("#tbqupricelist-quunitcost").val().replace(/[,]/g, ""));
//        var jj = uni * SKUQty;
//        var Total = jj * unitcost;
//        if(SKUQty=="0" || SKUQty=="0.00" ){
//            $("#tbqupricelist-quorderqty").val(addCommas(uni.toFixed(2)));
//        }else if(SKUQty > 0){
//            $("#tbqupricelist-quorderqty").val(addCommas(jj.toFixed(2)));
//            $("#QUExtenedCost").val(addCommas(Total.toFixed(2))); 
//        }
//});
////Calculate ItemPackSKUQty           
//$("#ItemPackSKUQty").keyup(function () {
//        $('input[id="ItemPackSKUQty"]').priceFormat({prefix: ''});
//        var uni = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
//        var packqty = parseFloat($("#tbqupricelist-qupackqty").val().replace(/[,]/g, ""));
//        var orq = parseFloat($("#tbqupricelist-qupackcost").val().replace(/[,]/g, ""));
//        var jj = uni * packqty;
//        var unitcost = uni/orq;
//        if (orq == "0" || orq == "0.00" ) {
//            $("#tbqupricelist-quunitcost").val('0.00');
//        } else if (orq > 0) {
//            $("#tbqupricelist-quorderqty").val(addCommas(jj.toFixed(2)));
//            $("#tbqupricelist-quunitcost").val(addCommas(unitcost.toFixed(2)));
//            var costnew = parseFloat($("#tbqupricelist-quunitcost").val().replace(/[,]/g, ""));
//            var Total = jj*costnew;
//            $("#QUExtenedCost").val(addCommas(Total.toFixed(2)));
//        }
//        if(packqty =="0"||packqty=="0.00"){
//            $("# tbqupricelist-quorderqty").val('0.00');
//        }else if(packqty>0){
//             $("#tbqupricelist-quorderqty").val(addCommas(jj.toFixed(2)));
//        }
//});
////Calculate PackCost       
//$("#tbqupricelist-qupackcost").keyup(function () {
//        $('input[id="tbqupricelist-qupackcost"]').priceFormat({prefix: ''});
//        var uni = parseFloat($("#tbqupricelist-qupackcost").val().replace(/[,]/g, ""));
//        var packqty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
//        var orq = parseFloat($("#tbqupricelist-quorderqty").val().replace(/[,]/g, ""));
//        var jj = orq * packqty;
//        var unitcost = packqty/uni;
//        if (packqty == "0" || packqty == "0.00" ) {
//            $("#tbqupricelist-quunitcost").val('0.00');
//        } else if (packqty > 0) {
//            $("#tbqupricelist-quunitcost").val(addCommas(unitcost.toFixed(2)));
//            var costnew = parseFloat($("#tbqupricelist-quunitcost").val().replace(/[,]/g, ""));
//            var Total = jj*costnew;
//            $("#QUExtenedCost").val(addCommas(Total.toFixed(2)));
//        }
//});
////Calculate OderQty       
//$("#tbqupricelist-quorderqty").keyup(function () {
//        $('input[id="tbqupricelist-quorderqty"]').priceFormat({prefix: ''});
//        var uni = parseFloat($("#tbqupricelist-quorderqty").val().replace(/[,]/g, ""));
//        var unicost = parseFloat($("#tbqupricelist-quunitcost").val().replace(/[,]/g, ""));
//        var Total = uni * unicost;
//        if (unicost == "0" || unicost == "0.00" ) {
//            $("#QUExtenedCost").val('0.00');
//        } else if (unicost > 0) {
//            $("#QUExtenedCost").val(addCommas(Total.toFixed(2)));
//        }
//});
////Calculate UnitCost     
//$("#tbqupricelist-quunitcost").keyup(function () {
//        $('input[id="tbqupricelist-quunitcost"]').priceFormat({prefix: ''});
//        var unicost = parseFloat($("#tbqupricelist-quunitcost").val().replace(/[,]/g, ""));
//        var unit = parseFloat($("#tbqupricelist-quorderqty").val().replace(/[,]/g, ""));
//        var Total = unit * unicost;
//        if (unit == "0" || unit == "0.00" ) {
//            $("#QUExtenedCost").val('0.00');
//        } else if (unit > 0) {
//            $("#QUExtenedCost").val(addCommas(Total.toFixed(2)));
//        }
//});
////Keyup QUMQO
//$("#tbqupricelist-qumqo").keyup(function () {
//        $('input[id="tbqupricelist-qumqo"]').priceFormat({prefix: ''});
//});        
////-------------------------------END Calculate------------------- 
////------------------------------Save Item------------------------     
////$('#formpricelisttpu').on('beforeSubmit', function(e)
////    {
////        
////    var \$form = $(this);
////            $.post(
////                    \$form.attr("action"), // serialize Yii2 form
////                    \$form.serialize()
////                    )
////            .done(function(result) {
////            if (result == 1)
////            {
////            $(\$form).trigger("reset");
////                    $.pjax.reload({container:'#tpu_detail'});
////                    //$('#formpricelisttpu').trigger("reset");
////                    $('#tpu-modal').modal('hide');
////                    $('#inputtpu').modal('hide');
////                    $('#getdatatpumodal').modal('hide');
////                    Notify('Saved Successfully!', 'top-right', '5000', 'success', 'fa-check', true);
////            } else
////            {
////            $("#message").html(result);
////            }
////            })
////            .fail(function()
////            {
////            console.log("server error");
////            });
////            return false;
////});
////------------------------------END Item------------------------     
JS;
$this->registerJs($script);
?>

