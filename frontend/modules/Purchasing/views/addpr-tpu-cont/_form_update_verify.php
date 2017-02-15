<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
?>

<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_update_verify']);
?>

<div class="well">
    <div class="row">
        <input id="ItemPackID" type="hidden" value="<?php echo $ItemPackID ?>"/>
        <div class="col-xs-6">
            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'TMTID_TPU', ['class' => 'col-sm-4 control-label no-padding-right no-padding-right']) ?>
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
                    $form->field($modeledit, 'PCPlanNum', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:#f9f9f9'
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
                        'value' => empty($modeledit['PRItemStdCost']) ? NULL : number_format($modeledit['PRItemStdCost'], 2)
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
                        'value' => empty($modeledit['PRItemUnitCost']) ? NULL : number_format($modeledit['PRItemUnitCost'], 2)
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
                        'maxlength' => true,
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
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: #f9f9f9;text-align:right',
                        'value' => empty($modeledit['PRItemAvalible']) ? NULL : number_format($modeledit['PRItemAvalible'], 2),
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแบบ</label>
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
                        'value' => empty($PRPackQty) ? NULL : number_format($PRPackQty, 2),
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
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: #f9f9f9;text-align: right"  
                           value="<?php
                           echo empty($ItemPackSKUQty) ? NULL : number_format($ItemPackSKUQty, 2);
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemPackCost', ['showLabels' => false])->textInput([
                        'value' => empty($ItemPackCost) ? NULL : number_format($ItemPackCost, 2),
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
                        'value' => empty($PROrderQty) ? NULL : number_format($PROrderQty, 2),
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
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'value' => empty($PRUnitCost) ? NULL : number_format($PRUnitCost, 2),
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
                        'value' => number_format($PROrderQty * $PRUnitCost, 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>
            <input class="form-control" id="checkover" type="hidden" name="checkover"/>
        </div>
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::submitButton($modeledit->isNewRecord ? 'Save' : 'Save', ['class' => $modeledit->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<!--JSScript/-->
<?php
$script = <<< JS
$(document).ready(function () {
        var ItemPackID = $("#ItemPackID").val();
        $("#vwpritemdetail2-itempackid").val(ItemPackID).trigger("change");
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
    
/* คำนวณ on chang หน่วยแพค */
$('#vwpritemdetail2-itempackid').on('change', function () {
    var TMTID_TPU = $("#vwpritemdetail2-tmtid_tpu").val();
    var ItemPackUnit = $(this).find("option:selected").val();
    var qty = parseFloat($("#vwpritemdetail2-prpackqty").val().replace(/[,]/g, ""));
    var itempackcost = parseFloat($("#vwpritemdetail2-itempackcost").val().replace(/[,]/g, ""));//ราคาต่อแพค
    if (ItemPackUnit != '') {
        $.ajax({
            url: "index.php?r=Purchasing/addpr-tpu-cont/get-qtytpu",
            type: "post",
            data: {TMTID_TPU: TMTID_TPU, ItemPackUnit: ItemPackUnit, qty: qty},
            dataType: 'json',
            success: function (data) {
                $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                var unitcost = itempackcost / SKUQty;
                var jj = (SKUQty) * (qty);
                var Total = jj * unitcost;
                if (data.qty == 0) {
                    $('#vwpritemdetail2-prorderqty').val('0.00');
                } else {
                    $("#vwpritemdetail2-prorderqty").val(addCommas(jj.toFixed(2)));
                    $("#vwpritemdetail2-prextendedcost").val(addCommas(Total.toFixed(2)));
                    $("#vwpritemdetail2-prunitcost").val(addCommas(unitcost.toFixed(2)));
                }
            }
        });
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
$('#form_update_verify').on('beforeSubmit', function (e)
{
    var prunitcost = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
    var pritemunitcost = parseFloat($("#vwpritemdetail2-pritemunitcost").val().replace(/[,]/g, ""));
    var pritemavalible = parseFloat($("#vwpritemdetail2-pritemavalible").val().replace(/[,]/g, ""));
    var prorderqty = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr("action"), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                if (result == 'over')
                {
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
                                            $('#verify-tpu-cont-modal').modal('hide');
                                    $('#form_update_verify').trigger("reset");
                                    swal("Save Complete!", "", "success");
                                    $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                } else {
                                    l.ladda('stop');
                                    //$('#verify-tpu-cont-modal').modal('hide');
                                    //$('#form_update_verify').trigger("reset");
                                }
                            });
                } else if (result == 'stdover') {
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
                                                                                    $('#verify-tpu-cont-modal').modal('hide');
                                                                            $('#form_update_verify').trigger("reset");
                                                                            swal("Save Complete!", "", "success");
                                                                            $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                                        } else {
                                                                            l.ladda('stop');
                                                                            //$('#verify-tpu-cont-modal').modal('hide');
                                                                            //$('#form_update_verify').trigger("reset");
                                                                        }
                                                                    });
                                                        } else {
                                                            l.ladda('stop');
                                                            $('#checkover').val('1');
                                                            $.post(
                                                                    form.attr("action"), // serialize Yii2 form
                                                                    form.serialize()
                                                                    ),
                                                                    $('#verify-tpu-cont-modal').modal('hide');
                                                            $('#form_update_verify').trigger("reset");
                                                            swal("Save Complete!", "", "success");
                                                            $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                        }
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#verify-tpu-cont-modal').modal('hide');
                                                        //$('#form_update_verify').trigger("reset");
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
                                                                    $('#verify-tpu-cont-modal').modal('hide');
                                                            $('#form_update_verify').trigger("reset");
                                                            swal("Save Complete!", "", "success");
                                                            $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                        } else {
                                                            l.ladda('stop');
                                                            //$('#verify-tpu-cont-modal').modal('hide');
                                                            //$('#form_update_verify').trigger("reset");
                                                        }
                                                    });
                                        } else {
                                            l.ladda('stop');
                                            $('#checkover').val('1');
                                            $.post(
                                                    form.attr("action"), // serialize Yii2 form
                                                    form.serialize()
                                                    ),
                                                    $('#verify-tpu-cont-modal').modal('hide');
                                            $('#form_update_verify').trigger("reset");
                                            swal("Save Complete!", "", "success");
                                            $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                        }
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#verify-tpu-cont-modal').modal('hide');
                                    //$('#form_update_verify').trigger("reset");
                                }
                            });
                } else if (result == 'unitover') { /* กรณีที่ราคาต่อหน่วยที่ขอซื้อเกินราคากลางในแผน */
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
                                                                $('#verify-tpu-cont-modal').modal('hide');
                                                        $('#form_update_verify').trigger("reset");
                                                        swal("Save Complete!", "", "success");
                                                        $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                                        $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                    } else {
                                                        l.ladda('stop');
                                                        //$('#verify-tpu-cont-modal').modal('hide');
                                                        //$('#form_update_verify').trigger("reset");
                                                    }
                                                });
                                    } else {
                                        l.ladda('stop');
                                        $('#checkover').val('1');
                                        $.post(
                                                form.attr("action"), // serialize Yii2 form
                                                form.serialize()
                                                ),
                                                $('#verify-tpu-cont-modal').modal('hide');
                                        $('#form_update_verify').trigger("reset");
                                        swal("Save Complete!", "", "success");
                                        $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                        $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                    }
                                } else {
                                    l.ladda('stop');
                                    //$('#verify-tpu-cont-modal').modal('hide');
                                    //$('#form_update_verify').trigger("reset");
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
                                            $('#verify-tpu-cont-modal').modal('hide');
                                    $('#form_update_verify').trigger("reset");
                                    swal("Save Complete!", "", "success");
                                    $('#SaveDraftVerify').removeClass("disabled", "disabled");
                                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                } else {
                                    l.ladda('stop');
                                    //$('#verify-tpu-cont-modal').modal('hide');
                                    //$('#form_update_verify').trigger("reset");
                                }
                            });
                } else {
                    $(form).trigger("reset");
                    $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                    $('#verify-tpu-cont-modal').modal('hide');
                    $('#form_update_verify').trigger("reset");
                    swal("Save Complete!", "", "success");
                    $('#SaveDraftVerify').removeClass("disabled", "disabled");
                    l.ladda('stop');
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
    var ItemPackID = $("#ItemPackID").val();
        
    if(ItemPackID == ""){
       document.getElementById("ชิ้น").checked = true;
       if ($("input[id=ชิ้น]").is(":checked"))
        {
             Chin();
        }
   }else{
        document.getElementById("แพค").checked = true;
        if ($("input[id=แพค]").is(":checked"))
        {
             Pack();
        }
   }
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
function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").attr('readonly', 'readonly');
        $("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
        $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#FFFF99');
        $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#f9f9f9');
    }
    function Pack() {
        $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").removeAttr('readonly');
        $("#vwpritemdetail2-itempackid").removeAttr('disabled');
        $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#FFFF99');
        $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#f9f9f9');
    }
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'update-verify');
?>
