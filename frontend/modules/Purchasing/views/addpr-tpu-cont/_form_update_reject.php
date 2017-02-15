<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\Inventory\models\VwTpuplanDetailAvalible;
use app\models\TbPackunit;
?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetailtpu_cont']);
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
                        'data' => ArrayHelper::map(VwTpuplanDetailAvalible::find()->where(['PCPlanNum' => $PCPlanNum])->all(), 'PCPlanNum', 'PCPlanNum'),
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
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemStdCost']) ? NULL : number_format($modeledit['PRItemStdCost'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemUnitCost', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemUnitCost', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemUnitCost']) ? NULL : number_format($modeledit['PRItemUnitCost'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemOrderQty', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemOrderQty', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemOrderQty']) ? NULL : number_format($modeledit['PRItemOrderQty'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRApprovedOrderQtySum', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRApprovedOrderQtySum', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRApprovedOrderQtySum']) ? NULL : number_format($modeledit['PRApprovedOrderQtySum'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'PRItemAvalible', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRItemAvalible', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemAvalible']) ? NULL : number_format($modeledit['PRItemAvalible'], 2),
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
                        'value' => empty($modeledit['PRPackQty']) ? NULL : number_format($modeledit['PRPackQty'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modeledit, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
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
                <label class="col-sm-4 control-label no-padding-right">ปริมาณบรรจุต่อแพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: #f9f9f9;text-align: right"  
                           value="<?php
                           echo empty($ItemPackSKUQty) ? NULL : number_format($ItemPackSKUQty, 2);
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อแพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemPackCost', ['showLabels' => false])->textInput([
                        'value' => empty($modeledit['ItemPackCost']) ? NULL : number_format($modeledit['ItemPackCost'], 2),
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
                        'value' => empty($modeledit['PROrderQty']) ? NULL : number_format($modeledit['PROrderQty'], 2),
                        'style' => 'background-color: white;text-align:right',
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
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'value' => empty($modeledit['PRUnitCost']) ? NULL : number_format($modeledit['PRUnitCost'], 2),
                        'style' => 'background-color: white;text-align:right',
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
                        'value' => number_format($modeledit['PROrderQty'] * $modeledit['PRUnitCost'], 2),
                        'style' => 'background-color: #f9f9f9;text-align:right',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <input class="form-control" id="checkover" type="hidden" name="checkover"/>
        <input type="hidden" id="vwpritemdetail2temp-ids_pr_selected" name="VwPritemdetail2[ids_PR_selected]" value="<?php echo $modeledit['ids_PR_selected']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-prid" name="VwPritemdetail2[PRID]" value="<?php echo $modeledit['PRID']; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-ids" name="VwPritemdetail2[ids]" value="<?php echo $modeledit['ids']; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-ids" name="VwPritemdetail2[TMTID_GPU]" value="<?php echo $TMTID_GPU; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-itemid" name="VwPritemdetail2[ItemID]" value="<?php echo $ItemID; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-itempackunit" name="VwPritemdetail2[ItemPackUnit]" value="<?php echo $modeledit['ItemPackUnit']; ?>"/>
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::submitButton($modeledit->isNewRecord ? 'Save' : 'Save', ['class' => $modeledit->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'expand-left']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!--JSScript/-->
<?php
$script = <<< JS
/* ราคาซื้อครั้งล่าสุด */        
$("#vwpritemdetail2-prlastunitcost").keyup(function () {
    $('input[id="vwpritemdetail2-prlastunitcost"]').priceFormat({prefix: ''});
});
$(document).ready(function () {
        var ItemPackUnit = $("#vvwpritemdetail2temp-itempackunit").val();
        $("#vwpritemdetail2-itempackid").val(ItemPackUnit).trigger("change");
    });
/* คำนวณ on chang หน่วยแพค */
$('#vwpritemdetail2-itempackid').on('change', function () {
    var TMTID_TPU = $("#vwpritemdetail2-tmtid_tpu").val();
    var ItemPackUnit = $(this).find("option:selected").val();
    var qty = parseFloat($("#vwpritemdetail2-prpackqty").val().replace(/[,]/g, ""));
    var itempackcost = parseFloat($("#vwpritemdetail2-itempackcost").val().replace(/[,]/g, ""));//ราคาต่อแพค
    if (ItemPackUnit != "") {
        $.ajax({
            url: "index.php?r=Purchasing/addpr-tpu-cont/get-qtytpu",
            type: "post",
            data: {TMTID_TPU: TMTID_TPU, ItemPackUnit: ItemPackUnit, qty: qty},
            dataType: 'json',
            success: function (data) {
                $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                var jj = (SKUQty) * (qty);
                if (itempackcost >= 0 && SKUQty > 0) {
                    var unitcost = itempackcost / SKUQty;
                    var Total = jj * unitcost;/* จำนวนขอซื้อ x ราคาต่อหน่วย จะได้ราคารวม */
                    $("#vwpritemdetail2-prextendedcost").val(addCommas(Total.toFixed(2)));
                    $("#vwpritemdetail2-prunitcost").val(addCommas(unitcost.toFixed(2)));
                }
                if (qty >= 0) {
                    $("#vwpritemdetail2-prorderqty").val(addCommas(jj.toFixed(2)));
                }
            }
        });
    }
});

/* getdata on chang pcplannum */
$('#vwpritemdetail2-pcplannum').on('change', function () {
    var TMTID_TPU = $("#vwpritemdetail2-tmtid_tpu").val();
    var PCPlanNum = $(this).find("option:selected").text();
    if (PCPlanNum != "") {
        $.post({
            url: "index.php?r=Purchasing/addpr-tpu-cont/getdata-pcplantpu", // your controller action
            dataType: 'json',
            data: {PCPlanNum: PCPlanNum, TMTID_TPU: TMTID_TPU},
            success: function (data) {
                $('#vwpritemdetail2-itemname').val(data.ItemName);
                $('#vwpritemdetail2-pritemstdcost').val(data.GPUStdCost);
                $('#vwpritemdetail2-pritemunitcost').val(data.TPUUnitCost);
                $('#vwpritemdetail2-pritemorderqty').val(data.TPUOrderQty);
                $('#vwpritemdetail2-prapprovedorderqtysum').val(data.PRApprovedOrderQty);
                $('#vwpritemdetail2-pritemavalible').val(data.PRTPUAvalible);
            },
        });
    }
});
/* คำนวณขอซื้อ */
$("#vwpritemdetail2-prorderqty").keyup(function () {
    $('input[id="vwpritemdetail2-prorderqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
    var pritemavalible = parseFloat($("#vwpritemdetail2-pritemavalible").val().replace(/[,]/g, ""));
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
        $("#vwpritemdetail2-prextendedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwpritemdetail2-prextendedcost").val('0.00');
    }
});
/* คำนวณราคาต่อหน่วย */
$("#vwpritemdetail2-prunitcost").keyup(function () {
    $('input[id="vwpritemdetail2-prunitcost"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));
    var pritemunitcost = parseFloat($("#vwpritemdetail2-pritemunitcost").val().replace(/[,]/g, ""));
    var pritemstdcost = parseFloat($("#vwpritemdetail2-pritemstdcost").val().replace(/[,]/g, ""));
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
        $("#vwpritemdetail2-prextendedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwpritemdetail2-prextendedcost").val('0.00');
    }
});
/* คำนวณจำนวนแพค */
$("#vwpritemdetail2-prpackqty").keyup(function () {
    $('input[id="vwpritemdetail2-prpackqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#vwpritemdetail2-prpackqty").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
    var prunitcost = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
    var jj = uni * orq;
    var Total = jj * prunitcost;
    if (orq == 0) {
        $("#vwpritemdetail2-prorderqty").val(addCommas(uni.toFixed(2)));
    } else if (orq > 0) {
        orq = orq.toFixed(2);
        $("#vwpritemdetail2-prorderqty").val(addCommas(jj.toFixed(2)));
        $("#vwpritemdetail2-prextendedcost").val(addCommas(Total.toFixed(2)));
    }
});
/* คำนวณราคาต่อแพค */
$("#vwpritemdetail2-itempackcost").keyup(function () {
    $('input[id="vwpritemdetail2-itempackcost"]').priceFormat({prefix: ''});
    var qty = $("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, "");
    var uni = parseFloat($("#vwpritemdetail2-itempackcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
    var pritemunitcost = parseFloat($("#vwpritemdetail2-pritemunitcost").val().replace(/[,]/g, ""));
    if (orq > 0) {
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwpritemdetail2-prextendedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwpritemdetail2-prunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2-prunitcost").val('0.00');
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
$('#formdetailtpu_cont').on('beforeSubmit', function (e)
{
    var pritemunitcost = parseFloat($("#vwpritemdetail2-pritemunitcost").val().replace(/[,]/g, ""));/* ราคาต่อหน่วยตามแผน */
    var prunitcost = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));/* ราคาต่อหน่วยขอซื้อ */
    var pritemavalible = parseFloat($("#vwpritemdetail2-pritemavalible").val().replace(/[,]/g, ""));/* จำนวนที่ขอซื้อได้ */
    var prorderqty = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));/* จำนวนที่ขอซื้อได้ */
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
                } else if (result == 'overall') { /* กรณีที่จำนวนขอซื้อเกินจำนวนที่ขอซื้อได้ในแผน */
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
                                            $('#tpu-cont-modal').modal('hide');
                                    $('#getdatatpucontmodal').modal('hide');
                                    $('.bs-modal-lg').modal('hide');
                                    swal("Save Complete!", "", "success");
                                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-cont-modal').modal('hide');
                                    //$('#formdetailtpu_cont').trigger("reset");
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
                                                                                    $('#tpu-cont-modal').modal('hide');
                                                                            $('#getdatatpucontmodal').modal('hide');
                                                                            $('.bs-modal-lg').modal('hide');
                                                                            swal("Save Complete!", "", "success");
                                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                                        } else {
                                                                            l.ladda('stop');
                                                                            //$('#tpu-cont-modal').modal('hide');
                                                                            //$('#formdetailtpu_cont').trigger("reset");
                                                                        }
                                                                    });
                                                        } else {
                                                            l.ladda('stop');
                                                            $('#checkover').val('1');
                                                            $.post(
                                                                    form.attr("action"), // serialize Yii2 form
                                                                    form.serialize()
                                                                    ),
                                                                    $('#tpu-cont-modal').modal('hide');
                                                            $('#getdatatpucontmodal').modal('hide');
                                                            $('.bs-modal-lg').modal('hide');
                                                            swal("Save Complete!", "", "success");
                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                        }
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#tpu-cont-modal').modal('hide');
                                                        //$('#formdetailtpu_cont').trigger("reset");
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
                                                                    $('#tpu-cont-modal').modal('hide');
                                                            $('#getdatatpucontmodal').modal('hide');
                                                            $('.bs-modal-lg').modal('hide');
                                                            swal("Save Complete!", "", "success");
                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                        } else {
                                                            l.ladda('stop');
                                                            //$('#tpu-cont-modal').modal('hide');
                                                            //$('#formdetailtpu_cont').trigger("reset");
                                                        }
                                                    });
                                        } else {
                                            l.ladda('stop');
                                            $('#checkover').val('1');
                                            $.post(
                                                    form.attr("action"), // serialize Yii2 form
                                                    form.serialize()
                                                    ),
                                                    $('#tpu-cont-modal').modal('hide');
                                            $('#getdatatpucontmodal').modal('hide');
                                            $('.bs-modal-lg').modal('hide');
                                            swal("Save Complete!", "", "success");
                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                        }
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-cont-modal').modal('hide');
                                    //$('#formdetailtpu_cont').trigger("reset");
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
                                                                $('#tpu-cont-modal').modal('hide');
                                                        $('#getdatatpucontmodal').modal('hide');
                                                        $('.bs-modal-lg').modal('hide');
                                                        swal("Save Complete!", "", "success");
                                                        $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#tpu-cont-modal').modal('hide');
                                                        //$('#formdetailtpu_cont').trigger("reset");
                                                    }
                                                });
                                    } else {
                                        l.ladda('stop');
                                        $('#checkover').val('1');
                                        $.post(
                                                form.attr("action"), // serialize Yii2 form
                                                form.serialize()
                                                ),
                                                $('#tpu-cont-modal').modal('hide');
                                        $('#getdatatpucontmodal').modal('hide');
                                        $('.bs-modal-lg').modal('hide');
                                        swal("Save Complete!", "", "success");
                                        $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-cont-modal').modal('hide');
                                    //$('#formdetailtpu_cont').trigger("reset");
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
                                            $('#tpu-cont-modal').modal('hide');
                                    $('#getdatatpucontmodal').modal('hide');
                                    $('.bs-modal-lg').modal('hide');
                                    swal("Save Complete!", "", "success");
                                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                } else {
                                    l.ladda('stop');
                                    //$('#tpu-cont-modal').modal('hide');
                                    //$('#formdetailtpu_cont').trigger("reset");
                                }
                            });
                } else {
                    l.ladda('stop');
                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                    $('#tpu-cont-modal').modal('hide');
                    $('#getdatatpucontmodal').modal('hide');
                    $('.bs-modal-lg').modal('hide');
                    swal("Save Complete!", "", "success");
                }
            })
            .fail(function ()
            {
                console.log("server error");
                swal("OOPS !", "เกิดข้อผิดพลาด! :)", "error");
                l.ladda('stop');
            });
    return false;
});
        
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
});
        
$(document).ready(function () {
        var itempackid = $("#vwpritemdetail2-itempackid").val();
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
function Pack() {
        $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").removeAttr('readonly');
        $("#vwpritemdetail2-itempackid").removeAttr('disabled');
        $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#FFFF99');
        $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#f9f9f9');
    }
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").attr('readonly', 'readonly');
        $("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
        $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#FFFF99');
        $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#f9f9f9');
    }
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'update');
?>
