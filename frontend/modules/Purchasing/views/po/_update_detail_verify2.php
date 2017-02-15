<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\models\TbPackunit;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_edit_po_detail_verify2']); ?>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <?= Html::activeLabel($modeledit, 'ItemID', ['class' => 'col-sm-3 control-label no-padding-right']) ?>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:#f9f9f9',
                                'value' => $Item['ItemID'],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($modeledit, 'TMTID_TPU', ['class' => 'col-sm-3 control-label no-padding-right']) ?>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'TMTID_TPU', ['showLabels' => false])->textInput([
                                'readonly' => true,
                                'style' => 'background-color:#f9f9f9',
                                'value' => empty($Item['TMTID_TPU']) ? NULL : $Item['TMTID_TPU'],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">รายการสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'ItemDetail', ['showLabels' => false])->textarea([
                                'rows' => 10,
                                'readonly' => true,
                                'style' => 'background-color:#f9f9f9',
                                'value' => $ItemDetail,
                            ])
                            ?>
                        </div>
                    </div>
                    <?=
                    $form->field($modeledit, 'ids', ['showLabels' => false])->hiddenInput([
                        'readonly' => true,
                    ])
                    ?>
                    <?=
                    $form->field($modeledit, 'TMTID_GPU', ['showLabels' => false])->hiddenInput([
                        'readonly' => true,
                        'value' => $Item['TMTID_GPU'],
                    ])
                    ?>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right"></label>
                        <div class="col-sm-8">
                            <input type="hidden" name="PackChin">
                            <div class="radio">
                                <label><input type="radio" name="PackChin" value="1" id="แพค"> <span class="text">แพค  </span></label>
                                <label><input type="radio" name="PackChin" value="0" id="ชิ้น"> <span class="text">ชิ้น  </span></label>
                            </div> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POPackQtyApprove', ['showLabels' => false])->textInput([
                                'style' => 'background-color: #f9f9f9;text-align:right',
                                'value' => empty($POPackQtyApprove) ? NULL : number_format($POPackQtyApprove, 2)
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                        <div class="col-sm-8">

                            <?=
                            $form->field($modeledit, 'POItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
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
                        <label class="col-sm-3 control-label no-padding-right">ปริมาณ/ต่อแพค</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: #f9f9f9;text-align: right"  
                                   value="<?php
                                   echo empty($ItemPackSKUQty) ? NULL : number_format($ItemPackSKUQty, 2);
                                   ?>"/>
                        </div>
                    </div>

                    <br>
                    <div class="form-group" >
                        <label class="col-sm-3 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POPackCostApprove', ['showLabels' => false])->textInput([
                                'value' => empty($POPackCostApprove) ? NULL : number_format($POPackCostApprove, 2),
                                'style' => 'background-color: #f9f9f9;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-3 control-label no-padding-right">ขอซื้อ <a id="checkขอซื้อ"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POApprovedOrderQty', ['showLabels' => false])->textInput([
                                'value' => empty($POApprovedOrderQty) ? NULL : number_format($POApprovedOrderQty, 2),
                                'style' => 'background-color: #f9f9f9;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-3 control-label no-padding-right">หน่วย</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'DispUnit', ['showLabels' => false])->textInput([
                                'readonly' => true,
                                'style' => 'background-color: #f9f9f9;text-align:right',
                                'value' => $DispUnit
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-3 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POApprovedUnitCost', ['showLabels' => false])->textInput([
                                'value' => empty($POApprovedUnitCost) ? NULL : number_format($POApprovedUnitCost, 2),
                                'style' => 'background-color: #f9f9f9;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-3 control-label no-padding-right">รวมเป็นเงิน</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POExtenedCost', ['showLabels' => false])->textInput([
                                /*'readonly' => true,*/
                                'value' => number_format($POApprovedOrderQty * $POApprovedUnitCost, 2),
                                'style' => 'background-color: #ffff99;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>
                    <input type="hidden" name="VwPo2SubPr2Detail[ItemPackUnit]" id="vwpo2subpr2detail2-itempackunit" value="<?php echo $PackUnit; ?>"/>
                    <input type="hidden" name="VwPo2SubPr2Detail[POID]" id="vwpo2subpr2detail-itempackunit" value="<?php echo $POID; ?>"/>
                </div>
            </div>
            <br/>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div style="text-align: right">
                    <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Html::submitButton($modeledit->isNewRecord ? 'Save' : 'Save', ['class' => $modeledit->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'expand-left']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).ready(function () {
        var ItemPackID = $('#vwpo2subpr2detail2-itempackunit').val();
        $("#vwpo2subpr2detail2-poitempackid").val(ItemPackID).trigger("change");
        $('#vwpo2subpr2detail2-poextenedcost').autoNumeric('init', {mDec: '4'});
    });
    $('#form_edit_po_detail_verify2').on('beforeSubmit', function (e)
    {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
                var \$form = $(this);
        $.post(
                \$form.attr("action"), // serialize Yii2 form
                \$form.serialize()
                )
                .done(function(result) {
                if (result == 1)
                {
                $.pjax.reload({container:'#detail_verify_po2_type2'});
                        $('#modaledit').modal('hide');
                        $('#getdatavendor').modal('hide');
                        swal({
                        title: "",
                                text: "Save Complete!",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: true,
                                closeOnCancel: true,
                        },
                                function (isConfirm) {
                                if (isConfirm) {
                                l.ladda('stop');
                                        $(\$form).trigger("reset");
                                        $('#form_edit_po_detail_verify2').trigger("reset");
                                        $('#Verify').removeClass("disabled", "disabled");
                                }
                                });
                }
                else
                {
                    $("#message").html(result);
                    }
                }
                )
        .fail(function()
        {
            console.log("server error");
        }
        );
        return false;
    });

    $(document).ready(function () {
        var CheckPack = $("#vwpo2subpr2detail2-popackqtyapprove").val();
        if (CheckPack == "" || CheckPack == "0.00") {
            document.getElementById("ชิ้น").checked = true;
            if ($("input[id=ชิ้น]").is(":checked"))
            {
                Chin();
            }
        } else {
            document.getElementById("แพค").checked = true;
            if ($("input[id=แพค]").is(":checked"))
            {
                Pack();
            }
        }
    });
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

    /* คำนวณจำนวนแพค */
    $("#vwpo2subpr2detail2-popackqtyapprove").keyup(function () {
        $('#vwpo2subpr2detail2-popackqtyapprove').autoNumeric('init', {mDec: '4'});
        //$('input[id="vwpo2subpr2detail2-popackqtyapprove"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail2-popackqtyapprove").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwpo2subpr2detail2-poapprovedunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var Total = jj * prunitcost;
        if (orq == 0) {
            $("#vwpo2subpr2detail2-poapprovedorderqty").val(addCommas(uni.toFixed(4)));
        } else if (orq > 0) {
            orq = orq.toFixed(4);
            $("#vwpo2subpr2detail2-poapprovedorderqty").val(addCommas(jj.toFixed(4)));
            $("#vwpo2subpr2detail2-poextenedcost").val(addCommas(Total.toFixed(4)));
        }
    });

    /* คำนวณ on chang หน่วยแพค */
    $('#vwpo2subpr2detail2-poitempackid').on('change', function () {
        var ItemID = $("#vwpo2subpr2detail2-itemid").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#vwpo2subpr2detail2-popackqtyapprove").val().replace(/[,]/g, ""));
        var itempackcost = parseFloat($("#vwpo2subpr2detail2-popackcostapprove").val().replace(/[,]/g, ""));//ราคาต่อแพค
        if (ItemPackUnit != '') {
            $.ajax({
                url: "index.php?r=Purchasing/po/get-qty",
                type: "post",
                data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
                dataType: 'json',
                success: function (data) {
                    $('#ItemPackSKUQty').val(data.ItemPackSKUQty);//ปริมาณต่อแพค
                    var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));//ปริมาณต่อแพค
                    var jj = (SKUQty) * (qty); /* ปริมาณต่อแพค x จำนวนแพค จะได้จำนวนขอซื้อ  */
                    if (itempackcost >= 0) {
                        var unitcost = itempackcost / SKUQty;
                        var Total = jj * unitcost;/* จำนวนขอซื้อ x ราคาต่อหน่วย จะได้ราคารวม */
                        $("#vwpo2subpr2detail2-poextenedcost").val(addCommas(Total.toFixed(4)));
                        $("#vvwpo2subpr2detail2-poapprovedunitcost").val(addCommas(unitcost.toFixed(4)));
                    }

                    if (qty >= 0) {
                        $("#vwpo2subpr2detail2-poapprovedorderqty").val(addCommas(jj.toFixed(4)));
                    }
                }
            });
        }
    });

    /* คำนวณราคาต่อแพค */
    $("#vwpo2subpr2detail2-popackcostapprove").keyup(function () {
        $('#vwpo2subpr2detail2-popackcostapprove').autoNumeric('init', {mDec: '4'});
        //$('input[id="vwpo2subpr2detail2-popackcostapprove"]').priceFormat({prefix: ''});
        var qty = $("#vwpo2subpr2detail2-poapprovedorderqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwpo2subpr2detail2-popackcostapprove").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        if (orq > 0) {
            var jj = uni / orq;
            var ext = qty * jj;
            $("#vwpo2subpr2detail2-poextenedcost").val(addCommas(ext.toFixed(4)));
            if (uni > 0) {
                orq = orq.toFixed(4);
                $("#vwpo2subpr2detail2-poapprovedunitcost").val(addCommas(jj.toFixed(4)));
            } else {
                $("#vwpo2subpr2detail2-poapprovedunitcost").val('0.00');
            }
        }
    });

    /* คำนวณขอซื้อ */
    $("#vwpo2subpr2detail2-poapprovedorderqty").keyup(function () {
        $('#vwpo2subpr2detail2-poapprovedorderqty').autoNumeric('init', {mDec: '4'});
        //$('input[id="vwpo2subpr2detail2-poapprovedorderqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail2-poapprovedorderqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpo2subpr2detail2-poapprovedunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(4);
            $("#vwpo2subpr2detail2-poextenedcost").val(addCommas(jj.toFixed(4)));
        } else {
            $("#vwpo2subpr2detail2-poextenedcost").val('0.00');
        }
    });

    /* คำนวณราคาต่อหน่วย */
    $("#vwpo2subpr2detail2-poapprovedunitcost").keyup(function () {
        $('#vwpo2subpr2detail2-poapprovedunitcost').autoNumeric('init', {mDec: '4'});
        //$('input[id="vwpo2subpr2detail2-poapprovedunitcost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail2-poapprovedunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpo2subpr2detail2-poapprovedorderqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(4);
            $("#vwpo2subpr2detail2-poextenedcost").val(addCommas(jj.toFixed(4)));
        } else {
            $("#vwpo2subpr2detail2-poextenedcost").val('0.00');
        }
    });
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#vwpo2subpr2detail2-popackqtyapprove,#vwpo2subpr2detail2-popackcostapprove").attr('readonly', 'readonly');
        $("#vwpo2subpr2detail2-poitempackid").attr('disabled', 'disabled');
        $("#vwpo2subpr2detail2-poapprovedorderqty,#vwpo2subpr2detail2-poapprovedunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#vwpo2subpr2detail2-poapprovedorderqty,#vwpo2subpr2detail2-poapprovedunitcost').css('background-color', '#FFFF99');
        $('#vwpo2subpr2detail2-popackqtyapprove,#vwpo2subpr2detail2-popackcostapprove').css('background-color', '#f9f9f9');
    }

    function Pack() {
        $("#vwpo2subpr2detail2-popackqtyapprove,#vwpo2subpr2detail2-popackcostapprove").removeAttr('readonly');
        $("#vwpo2subpr2detail2-poitempackid").removeAttr('disabled');
        $("#vwpo2subpr2detail2-poapprovedorderqty,#vwpo2subpr2detail2-poapprovedunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#vwpo2subpr2detail2-popackqtyapprove,#vwpo2subpr2detail2-popackcostapprove').css('background-color', '#FFFF99');
        $('#vwpo2subpr2detail2-poapprovedorderqty,#vwpo2subpr2detail2-poapprovedunitcost').css('background-color', '#f9f9f9');
    }
JS;
$this->registerJs($script);
?>
