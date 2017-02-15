<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetailtpu']);
?>
<div class="well">
    <div class="row">
        <div class="col-xs-6">
            <input class="form-control" id="cmd" name="cmd" type="hidden"/>
            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'TMTID_TPU', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'TMTID_TPU', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:#f9f9f9'
                    ])
                    ?>
                </div> 
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PCPlanNum', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">

                    <?=
                    $form->field($modeledit, 'PCPlanNum', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\modules\Inventory\models\VwTpuplanDetailAvalible::find()->where(['PCPlanNum' => $PCPlanNum])->all(), 'PCPlanNum', 'PCPlanNum'),
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

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดยา</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemName', ['showLabels' => false])->textarea([
                        'rows' => 3,
                        'readonly' => true,
                        'style' => 'background-color:#f9f9f9',
                        'value' => $ItemName,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemStdCost', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemStdCost', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:#f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemStdCost']) ? '' : number_format($modeledit['PRItemStdCost'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemUnitCost', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemUnitCost', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemUnitCost']) ? '' : number_format($modeledit['PRItemUnitCost'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemOrderQty', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemOrderQty', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemOrderQty']) ? '' : number_format($modeledit['PRItemOrderQty'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRApprovedOrderQtySum', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRApprovedOrderQtySum', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRApprovedOrderQtySum']) ? '' : number_format($modeledit['PRApprovedOrderQtySum'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemAvalible', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemAvalible', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemAvalible']) ? '' : number_format($modeledit['PRItemAvalible'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRLastUnitCost', ['label' => 'ราคาซื้อครั้งล่าสุด' . '<font color="red"> *</font>', 'class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRLastUnitCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: #ffff99;text-align:right',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">ขอซื้อแบบ</label>
                <div class="col-sm-8">
                    <input type="hidden" name="PackChin">
                    <div class="radio">
                        <label>
                            <input name="PackChin" type="radio" value="1" id="แพค">
                            <span class="text">แพค </span>
                        </label>
                        <label>
                            <input name="PackChin" type="radio" value="0" id="ชิ้น">
                            <span class="text">ชิ้น </span>
                        </label>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => empty($modeledit['PRPackQty']) ? '' : number_format($modeledit['PRPackQty'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modeledit, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                    <div id="notpack"><?php echo $btn ?></div>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: #f9f9f9;text-align: right"  
                           value="<?php
                    if (empty($ItemPackSKUQty)) {
                        echo '';
                    } else {
                        echo number_format($ItemPackSKUQty, 2);
                    }
                    ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemPackCost', ['showLabels' => false])->textInput([
                        'value' => empty($modeledit['PRPackQty']) ? '' : number_format($modeledit['PRPackQty'], 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อ <a id="checkขอซื้อ"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PROrderQty', ['showLabels' => false])->textInput([
                        'value' => empty($modeledit['PROrderQty']) ? '' : number_format($modeledit['PROrderQty'], 2),
                        'style' => 'background-color: white;text-align:right',
                        'required' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeledit, 'DispUnit', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'DispUnit', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => $DispUnit,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'value' => empty($modeledit['PRUnitCost']) ? '' : number_format($modeledit['PRUnitCost'], 2),
                        'style' => 'background-color: white;text-align:right',
                        'required' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeledit, 'PRExtendedCost', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRExtendedCost', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'value' => empty($modeledit['PRExtendedCost']) ? '' : number_format($modeledit['PROrderQty'] * $modeledit['PRUnitCost'], 2),
                        'style' => 'background-color: #f9f9f9;text-align:right',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <input class="form-control" id="checkover" type="hidden" name="checkover"/>
        <input type="hidden" id="vwpritemdetail2temp-ids_pr_selected" name="VwPritemdetail2Temp[ids_PR_selected]" value="<?php echo $modeledit['ids_PR_selected']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-prid" name="VwPritemdetail2Temp[PRID]" value="<?php echo $modeledit['PRID']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-itemid" name="VwPritemdetail2Temp[ItemID]" value="<?php echo $ItemID; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-ids" name="VwPritemdetail2Temp[ids]" value="<?php echo $modeledit['ids']; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-ids" name="VwPritemdetail2Temp[TMTID_GPU]" value="<?php echo $TMTID_GPU; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-itempackunit" name="VwPritemdetail2Temp[ItemPackUnit]" value="<?php echo $modeledit['ItemPackUnit']; ?>"/>
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-success ladda-button" type="submit" data-style="expand-left">Save</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!--JSScript/-->
<?php
$script = <<< JS
/* ราคาซื้อครั้งล่าสุด */        
$("#vwpritemdetail2temp-prlastunitcost").keyup(function () {
    $('#vwpritemdetail2temp-prlastunitcost').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-prunitcost').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-prorderqty').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-itempackcost').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-prpackqty').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-prlastunitcost').autoNumeric('init',{mDec: '4'});
    $('#vwpritemdetail2temp-prextendedcost').autoNumeric('init',{mDec: '4'});
});
$(document).ready(function () {
    var ItemPackUnit = $("#vvwpritemdetail2temp-itempackunit").val();
    $("#vwpritemdetail2temp-itempackid").val(ItemPackUnit).trigger("change");

/* คำนวณ on chang หน่วยแพค */
$('#vwpritemdetail2temp-itempackid').on('change', function () {
    var TMTID_TPU = $("#vwpritemdetail2temp-tmtid_tpu").val();
    var ItemPackUnit = $(this).find("option:selected").val();
    var qty = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, "")) || 0;
    var itempackcost = parseFloat($("#vwpritemdetail2temp-itempackcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อแพค
    if (ItemPackUnit != '') {
        $.ajax({
            url: "get-qtytpu",
            type: "post",
            data: {TMTID_TPU: TMTID_TPU, ItemPackUnit: ItemPackUnit, qty: qty},
            dataType: 'json',
            success: function (data) {
                $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, "")) || 0;
                var jj = (SKUQty) * (qty);
                if (itempackcost >= 0 && SKUQty > 0) {
                    var unitcost = itempackcost / SKUQty;
                    var Total = jj * unitcost;/* จำนวนขอซื้อ x ราคาต่อหน่วย จะได้ราคารวม */
                    $("#vwpritemdetail2temp-prextendedcost").val(addCommas(Total.toFixed(2)));
                    $("#vwpritemdetail2temp-prunitcost").val(addCommas(unitcost.toFixed(2)));
                }
                if (data.qty == 0) {
                    $('#vwpritemdetail2temp-prorderqty').val('0.00');
                } else {
                    $("#vwpritemdetail2temp-prorderqty").val(addCommas(jj.toFixed(2)));
                }
            }
        });
    }
});

    /* getdata on chang pcplannum */
    $('#vwpritemdetail2temp-pcplannum').on('change', function () {
        var TMTID_TPU = $("#vwpritemdetail2temp-tmtid_tpu").val();
        var PCPlanNum = $(this).find("option:selected").text();
        if (PCPlanNum != '') {
            $.ajax({
                url: 'getdata-pcplangpu',
                type: 'POST',
                dataType: 'json',
                data: {PCPlanNum: PCPlanNum, TMTID_TPU: TMTID_TPU},
                success: function (data) {
                    $('#vwpritemdetail2temp-itemname').val(data.ItemName);
                    $('#vwpritemdetail2temp-pritemstdcost').val(data.GPUStdCost);
                    $('#vwpritemdetail2temp-pritemunitcost').val(data.TPUUnitCost);
                    $('#vwpritemdetail2temp-pritemorderqty').val(data.TPUOrderQty);
                    $('#vwpritemdetail2temp-prapprovedorderqtysum').val(data.PRApprovedOrderQty);
                    $('#vwpritemdetail2temp-pritemavalible').val(data.PRTPUAvalible);
                }
            });
        }
    });
});
        
/* คำนวณขอซื้อ */
$("#vwpritemdetail2temp-prorderqty").keyup(function () {
    //$('input[id="vwpritemdetail2temp-prorderqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, "")) || 0;
    var orq = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;
    var pritemavalible = parseFloat($("#vwpritemdetail2temp-pritemavalible").val().replace(/[,]/g, "")) || 0;
    /* if (pritemavalible > '0.00') {
        if (uni > pritemavalible) {
            swal({
                title: "",
                text: "ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        }
    } */
    var jj = uni * orq;
    if (orq > 0) {
        uni = uni.toFixed(2);
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwpritemdetail2temp-prextendedcost").val('0.00');
    }
});
        
/* คำนวณราคาต่อหน่วย */
$("#vwpritemdetail2temp-prunitcost").keyup(function () {
    //$('input[id="vwpritemdetail2temp-prunitcost"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;
    var orq = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, "")) || 0;
    var pritemunitcost = parseFloat($("#vwpritemdetail2temp-pritemunitcost").val().replace(/[,]/g, "")) || 0;
    var pritemstdcost = parseFloat($("#vwpritemdetail2temp-pritemstdcost").val().replace(/[,]/g, "")) || 0;
    if (pritemstdcost > '0.00') {
        if (uni > pritemstdcost) {
            swal({
                title: "",
                text: "ราคาต่อหน่วย เกิน ราคากลาง!",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        } else if (uni > pritemunitcost) {
            swal({
                title: "",
                text: "ราคาต่อหน่วย เกิน ราคาต่อหน่วยในแผน!",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        }
    } else {
        if (uni > pritemunitcost) {
            swal({
                title: "",
                text: "ราคาต่อหน่วย เกิน ราคาต่อหน่วยในแผน!",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        }
    }
    var jj = uni * orq;
    if (orq > 0) {
        uni = uni.toFixed(2);
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwpritemdetail2temp-prextendedcost").val('0.00');
    }
});
        
/* คำนวณจำนวนแพค */
$("#vwpritemdetail2temp-prpackqty").keyup(function () {
    //$('input[id="vwpritemdetail2temp-prpackqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, "")) || 0;
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, "")) || 0;
    var prunitcost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;
    var jj = uni * orq;
    var Total = jj * prunitcost;
    if (orq == 0) {
        $("#vwpritemdetail2temp-prorderqty").val(addCommas(uni.toFixed(2)));
    } else if (orq > 0) {
        orq = orq.toFixed(2);
        $("#vwpritemdetail2temp-prorderqty").val(addCommas(jj.toFixed(2)));
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(Total.toFixed(2)));
    }
});

/* คำนวณราคาต่อแพค */
$("#vwpritemdetail2temp-itempackcost").keyup(function () {
    //$('input[id="vwpritemdetail2temp-itempackcost"]').priceFormat({prefix: ''});
    var qty = $("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, "");
    var uni = parseFloat($("#vwpritemdetail2temp-itempackcost").val().replace(/[,]/g, "")) || 0;
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, "")) || 0;
    var pritemunitcost = parseFloat($("#vwpritemdetail2temp-pritemunitcost").val().replace(/[,]/g, "")) || 0;
    if (orq > 0) {
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwpritemdetail2temp-prunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2temp-prunitcost").val('0.00');
        }
    }
    if (pritemunitcost > 0) {
        if (jj > pritemunitcost) {
            swal({
                title: "",
                text: "ราคาต่อหน่วยที่ขอเกินราคาต่อหน่วยในแผน!",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        }
    }
});   

/* On Save */
$('#formdetailtpu').on('beforeSubmit', function (e)
{
    var pritemunitcost = parseFloat($("#vwpritemdetail2temp-pritemunitcost").val().replace(/[,]/g, "")) || 0;/* ราคาต่อหน่วยตามแผน */
    var prunitcost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;/* ราคาต่อหน่วยขอซื้อ */
    var pritemavalible = parseFloat($("#vwpritemdetail2temp-pritemavalible").val().replace(/[,]/g, "")) || 0;/* จำนวนที่ขอซื้อได้ */
    var prorderqty = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, "")) || 0;/* จำนวนที่ขอซื้อได้ */

    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr("action"), // serialize Yii2 form
            form.serialize()
            )
            .always(function () {

            })
            .done(function (result) {
                if (result == 0) /* กรณีที่ไม่ได้คีย์จำนวนขอซื้อ */
                {
                    //$(form).trigger("reset");
                    swal({
                        title: "",
                        text: "กรุณากรอกข้อมูลการขอซื้อ!",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                }
                            });
                } else if (result == 'overall') {
                    swal({
                        title: "ยืนยันข้อมูลขอซื้อ?",
                        text: "จำนวนที่ขอซื้อและราคาต่อหน่วยมากกว่าปริมาณในแผน!",
                        type: "warning",
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    $('#checkover').val('1');
                                    $.post(
                                            form.attr("action"), // serialize Yii2 form
                                            form.serialize()
                                            ),
                                            $.pjax.reload({container: '#tpu_pjax_id'});
                                    $('#tpu-modal').modal('hide');
                                    $('#getdatatpumodal').modal('hide');
                                    $('#formdetailtpu').trigger("reset");
                                    swal("Save Complete!", "", "success");
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-modal').modal('hide');
                                    //$('#formdetailtpu').trigger("reset");
                                }
                            });
                } else if (result == 'stdover') { /* กรณีที่ราคาต่อหน่วยที่ขอซื้อเกินราคากลางในแผน */
                    swal({
                        title: "ยืนยันข้อมูลขอซื้อ?",
                        text: "ราคาต่อหน่วย เกิน ราคากลาง!",
                        type: "warning",
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    if (prunitcost > pritemunitcost) { /* ให้เช็คก่อนว่าราคาต่อหน่วยเกินในแผนรึป่าว */
                                        swal({
                                            title: "ยืนยันข้อมูลขอซื้อ?",
                                            text: "ราคาต่อหน่วย เกิน ราคาต่อหน่วยในแผน!",
                                            type: "warning",
                                            confirmButtonText: "Confirm",
                                            showCancelButton: true,
                                            closeOnConfirm: false,
                                            closeOnCancel: true,
                                        },
                                                function (isConfirm) {
                                                    if (isConfirm) {
                                                        if (prorderqty > pritemavalible) {
                                                            swal({
                                                                title: "ยืนยันข้อมูลขอซื้อ?",
                                                                text: "ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!",
                                                                type: "warning",
                                                                confirmButtonText: "Confirm",
                                                                showCancelButton: true,
                                                                closeOnConfirm: false,
                                                                closeOnCancel: true,
                                                            },
                                                                    function (isConfirm) {
                                                                        if (isConfirm) {
                                                                            l.ladda('stop');
                                                                            $('#checkover').val('1');
                                                                            $.post(
                                                                                    form.attr("action"), // serialize Yii2 form
                                                                                    form.serialize()
                                                                                    ),
                                                                                    $.pjax.reload({container: '#tpu_pjax_id'});
                                                                            $('#tpu-modal').modal('hide');
                                                                            $('#getdatatpumodal').modal('hide');
                                                                            $('#formdetailtpu').trigger("reset");
                                                                            swal("Save Complete!", "", "success");
                                                                        } else {
                                                                            l.ladda('stop');
                                                                            //$('#tpu-modal').modal('hide');
                                                                            //$('#formdetailtpu').trigger("reset");
                                                                        }
                                                                    });
                                                        } else {
                                                            l.ladda('stop');
                                                            $('#checkover').val('1');
                                                            $.post(
                                                                    form.attr("action"), // serialize Yii2 form
                                                                    form.serialize()
                                                                    ),
                                                                    $.pjax.reload({container: '#tpu_pjax_id'});
                                                            $('#tpu-modal').modal('hide');
                                                            $('#getdatatpumodal').modal('hide');
                                                            $('#formdetailtpu').trigger("reset");
                                                            swal("Save Complete!", "", "success");
                                                        }
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#tpu-modal').modal('hide');
                                                        //$('#formdetailtpu').trigger("reset");
                                                    }
                                                });
                                    } else {
                                        if (prorderqty > pritemavalible) {
                                            swal({
                                                title: "ยืนยันข้อมูลขอซื้อ?",
                                                text: "ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!",
                                                type: "warning",
                                                confirmButtonText: "Confirm",
                                                showCancelButton: true,
                                                closeOnConfirm: false,
                                                closeOnCancel: true,
                                            },
                                                    function (isConfirm) {
                                                        if (isConfirm) {
                                                            l.ladda('stop');
                                                            $('#checkover').val('1');
                                                            $.post(
                                                                    form.attr("action"), // serialize Yii2 form
                                                                    form.serialize()
                                                                    ),
                                                                    $.pjax.reload({container: '#tpu_pjax_id'});
                                                            $('#tpu-modal').modal('hide');
                                                            $('#getdatatpumodal').modal('hide');
                                                            $('#formdetailtpu').trigger("reset");
                                                            swal("Save Complete!", "", "success");
                                                        } else {
                                                            l.ladda('stop');
                                                            //$('#tpu-modal').modal('hide');
                                                            //$('#formdetailtpu').trigger("reset");
                                                        }
                                                    });
                                        } else {
                                            l.ladda('stop');
                                            $('#checkover').val('1');
                                            $.post(
                                                    form.attr("action"), // serialize Yii2 form
                                                    form.serialize()
                                                    ),
                                                    $.pjax.reload({container: '#tpu_pjax_id'});
                                            $('#tpu-modal').modal('hide');
                                            $('#getdatatpumodal').modal('hide');
                                            $('#formdetailtpu').trigger("reset");
                                            swal("Save Complete!", "", "success");
                                        }
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-modal').modal('hide');
                                    //$('#formdetailtpu').trigger("reset");
                                }
                            });
                } else if (result == 'unitover') {
                    swal({
                        title: "ยืนยันข้อมูลขอซื้อ?",
                        text: "ราคาต่อหน่วย เกิน ราคาต่อหน่วยในแผน!",
                        type: "warning",
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    if (prorderqty > pritemavalible) {
                                        swal({
                                            title: "ยืนยันข้อมูลขอซื้อ?",
                                            text: "ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!",
                                            type: "warning",
                                            confirmButtonText: "Confirm",
                                            showCancelButton: true,
                                            closeOnConfirm: false,
                                            closeOnCancel: true,
                                        },
                                                function (isConfirm) {
                                                    if (isConfirm) {
                                                        l.ladda('stop');
                                                        $('#checkover').val('1');
                                                        $.post(
                                                                form.attr("action"), // serialize Yii2 form
                                                                form.serialize()
                                                                ),
                                                                $.pjax.reload({container: '#tpu_pjax_id'});
                                                        $('#tpu-modal').modal('hide');
                                                        $('#getdatatpumodal').modal('hide');
                                                        $('#formdetailtpu').trigger("reset");
                                                        swal("Save Complete!", "", "success");
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#tpu-modal').modal('hide');
                                                        //$('#formdetailtpu').trigger("reset");
                                                    }
                                                });
                                    } else {
                                        l.ladda('stop');
                                        $('#checkover').val('1');
                                        $.post(
                                                form.attr("action"), // serialize Yii2 form
                                                form.serialize()
                                                ),
                                                $.pjax.reload({container: '#tpu_pjax_id'});
                                        $('#tpu-modal').modal('hide');
                                        $('#getdatatpumodal').modal('hide');
                                        $('#formdetailtpu').trigger("reset");
                                        swal("Save Complete!", "", "success");
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-modal').modal('hide');
                                    //$('#formdetailtpu').trigger("reset");
                                }
                            });
                } else if (result == 'over') {
                    swal({
                        title: "ยืนยันข้อมูลขอซื้อ?",
                        text: "ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!",
                        type: "warning",
                        confirmButtonText: "Confirm",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    $('#checkover').val('1');
                                    $.post(
                                            form.attr("action"), // serialize Yii2 form
                                            form.serialize()
                                            ),
                                            $.pjax.reload({container: '#tpu_pjax_id'});
                                    $('#tpu-modal').modal('hide');
                                    $('#getdatatpumodal').modal('hide');
                                    $('#formdetailtpu').trigger("reset");
                                    swal("Save Complete!", "", "success");
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-modal').modal('hide');
                                    //$('#formdetailtpu').trigger("reset");
                                }
                            });
                } else {
                    l.ladda('stop');
                    $.pjax.reload({container: '#tpu_pjax_id'});
                    $('#tpu-modal').modal('hide');
                    $('#getdatatpumodal').modal('hide');
                    $('#formdetailtpu').trigger("reset");
                    swal("Save Complete!", "", "success");
                }
            })
            .fail(function ()
            {
                console.log("server error");
            });
    return false;
});
        
/*   */
$(document).ready(function () {
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
            Pack();
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
            Chin();
        }
    });

    var itempackid = $("#vwpritemdetail2temp-itempackid").val();
    if (itempackid == "") {
        document.getElementById("ชิ้น").checked = true;
        if ($("input[id=ชิ้น]").is(":checked"))
        {
            Chin();
        }
    } else {
        document.getElementById("แพค").checked = true;
        Pack();
    }
});

/*   */
function Pack() {
    $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").removeAttr('readonly');
    $("#vwpritemdetail2temp-itempackid").removeAttr('disabled');
    $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
    $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
    $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
    $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', '#FFFF99');
    $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#f9f9f9');
}
function Chin() {
    $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
    $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
    $("#vwpritemdetail2temp-itempackid").attr('disabled', 'disabled');
    $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").removeAttr('readonly');
    $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
    $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
    $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', '#f9f9f9');
}
JS;
$this->registerJs($script);
?>
