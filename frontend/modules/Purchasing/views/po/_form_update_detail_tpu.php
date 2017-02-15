<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_edit_po_detail']); ?>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <?= Html::activeLabel($modeledit, 'ItemID', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $Item['ItemID'],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($modeledit, 'TMTID_TPU', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'TMTID_TPU', ['showLabels' => false])->textInput([
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $Item['TMTID_TPU'],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">รายการสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'ItemDetail', ['showLabels' => false])->textarea([
                                'rows' => 13,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $Item['FSN_TMT'],
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
                        <label class="col-sm-4 control-label no-padding-right"></label>
                        <div class="col-sm-8">
                            <div class="radio">
                            <label><input type="radio" name="แพค" id="แพค" value="yes"/> <span class="text">แพค  </span></label>
                            <label><input type="radio" checked="checked" name="แพค" id="ชิ้น" value="no"/> <span class="text">ชิ้น  </span></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POPackQtyApprove', ['showLabels' => false])->textInput([
                                'style' => 'background-color: white;text-align:right',
                                'value' => number_format($POPackQtyApprove, 2)
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                        <div class="col-sm-8">

                            <?=
                            $form->field($modeledit, 'POItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
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
                        <label class="col-sm-4 control-label no-padding-right">ปริมาณ/ต่อแพค</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                                   value="<?php
                                   if ($ItemPackSKUQty == null) {
                                       echo '0.00';
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
                            $form->field($modeledit, 'POPackCostApprove', ['showLabels' => false])->textInput([
                                'value' => number_format($POPackCostApprove, 2),
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-4 control-label no-padding-right">ขอซื้อ <a id="checkขอซื้อ"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POApprovedOrderQty', ['showLabels' => false])->textInput([
                                'value' => number_format($POApprovedOrderQty, 2),
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-4 control-label no-padding-right">หน่วย</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'DispUnit', ['showLabels' => false])->textInput([
                                'readonly' => true,
                                'style' => 'background-color: white;text-align:right',
                                'value' => $DispUnit
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POApprovedUnitCost', ['showLabels' => false])->textInput([
                                'value' => number_format($POApprovedUnitCost, 2),
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-sm-4 control-label no-padding-right">รวมเป็นเงิน</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'POExtenedCost', ['showLabels' => false])->textInput([
                                /*'readonly' => true,*/
                                //'value' => number_format($POApprovedOrderQty * $POApprovedUnitCost, 2),
                                'style' => 'background-color: #ffff99;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>
                    <input type="hidden"  id="vwitemlisttpu-itemid" value="<?php echo $Item['ItemID']; ?>"/>
                    <input type="hidden" name="VwPo2SubPr2Detail[ItemPackUnit]" id="vwpo2subpr2detail-itempackunit" value="<?php echo $PackUnit; ?>"/>
                </div>

                <div class="col-md-12">
                    <div class="form-group" style="text-align: right">
                        <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$(document).ready(function () {
        var ItemPackID = $('#vwpo2subpr2detail-itempackunit').val();
        $("#vwpo2subpr2detail-poitempackid").val(ItemPackID).trigger("change");
        $('#vwpo2subpr2detail-poextenedcost').autoNumeric('init', {mDec: '4'});
    });
$('#form_edit_po_detail').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1)
            {
            $(\$form).trigger("reset");
                    $.pjax.reload({container:'#po_detail_listgpu'});
                    //$.pjax.reload({container:'#po_detail_listgpu_potype2'});
                    $('#SelectTableTpu').modal('hide');
                    $('#modaledit').modal('hide');
                    $('#form_edit_po_detail').trigger("reset");
                    Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
            } else
            {
            $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });
$(document).ready(function () {
        var CheckPack = $("#vwpo2subpr2detail-popackqtyapprove").val();
        if (CheckPack == "" || CheckPack == "0.00") {
            document.getElementById("ชิ้น").checked = true;
            if ($("input[id=ชิ้น]").is(":checked"))
            {
                $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
                $("#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove").attr('readonly', 'readonly');
                //$("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
                $("#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost").removeAttr('readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
                $('#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost').css('background-color', '#FFFF99');
                $('#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove').css('background-color', 'white');
            }
        } else {
            document.getElementById("แพค").checked = true;
            if ($("input[id=แพค]").is(":checked"))
            {
                $("#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove").removeAttr('readonly');
                //$("#vwpritemdetail2-itempackid").removeAttr('disabled');
                $("#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost").attr('readonly', 'readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
                $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
                $('#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove').css('background-color', '#FFFF99');
                $('#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost').css('background-color', 'white');
            }
        }
    });
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
            $("#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove").removeAttr('readonly');
            //$("#vwpritemdetail2-itempackid").removeAttr('disabled');
            $("#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost").attr('readonly', 'readonly');
            $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
            $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
            $('#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove').css('background-color', '#FFFF99');
            $('#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
            $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
            $("#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove").attr('readonly', 'readonly');
            //$("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
            $("#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost").removeAttr('readonly');
            $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
            $('#vwpo2subpr2detail-poapprovedorderqty,#vwpo2subpr2detail-poapprovedunitcost').css('background-color', '#FFFF99');
            $('#vwpo2subpr2detail-popackqtyapprove,#vwpo2subpr2detail-popackcostapprove').css('background-color', 'white');
        }
    });//คำนวณจำนวนแพค
    $("#vwpo2subpr2detail-popackqtyapprove").keyup(function () {
        $('input[id="vwpo2subpr2detail-popackqtyapprove"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail-popackqtyapprove").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwpo2subpr2detail-poapprovedunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var Total = jj * prunitcost;
        if (orq == 0) {
            $("#vwpo2subpr2detail-poapprovedorderqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            $("#vwpo2subpr2detail-poapprovedorderqty").val(addCommas(jj.toFixed(2)));
            $("#vwpo2subpr2detail-poextenedcost").val(addCommas(Total.toFixed(2)));
        }
    });
    //คำนวณ on chang หน่วยแพค
    $('#vwpo2subpr2detail-poitempackid').on('change', function () {
        var ItemID = $("#vwpo2subpr2detail-itemid").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#vwpo2subpr2detail-popackqtyapprove").val().replace(/[,]/g, ""));
        var PRUnitCost = parseFloat($("#vwpo2subpr2detail-poapprovedunitcost").val().replace(/[,]/g, ""));
        $.ajax({
            url: "index.php?r=Purchasing/po/get-qty",
            type: "post",
            data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
            dataType: 'json',
            success: function (data) {
                $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                var jj = (SKUQty) * (qty);
                var Total = jj * PRUnitCost;
                if (data.qty == 0) {
                    $('#vwpo2subpr2detail-poapprovedorderqty').val();
                } else {
                    $("#vwpo2subpr2detail-poapprovedorderqty").val(addCommas(jj.toFixed(2)));
                    $("#vwpo2subpr2detail-poextenedcost").val(addCommas(Total.toFixed(2)));
                }
            }
        });
    });
//คำนวณราคาต่อแพค
    $("#vwpo2subpr2detail-popackcostapprove").keyup(function () {
        $('input[id="vwpo2subpr2detail-popackcostapprove"]').priceFormat({prefix: ''});
        var qty = $("#vwpo2subpr2detail-poapprovedorderqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwpo2subpr2detail-popackcostapprove").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwpo2subpr2detail-poextenedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwpo2subpr2detail-poapprovedunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpo2subpr2detail-poapprovedunitcost").val('0.00');
        }
    });
    //คำนวณขอซื้อ
    $("#vwpo2subpr2detail-poapprovedorderqty").keyup(function () {
        $('input[id="vwpo2subpr2detail-poapprovedorderqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail-poapprovedorderqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpo2subpr2detail-poapprovedunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpo2subpr2detail-poextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpo2subpr2detail-poextenedcost").val('0.00');
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#vwpo2subpr2detail-poapprovedunitcost").keyup(function () {
        $('input[id="vwpo2subpr2detail-poapprovedunitcost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpo2subpr2detail-poapprovedunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpo2subpr2detail-poapprovedorderqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpo2subpr2detail-poextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpo2subpr2detail-poextenedcost").val('0.00');
        }
    });

JS;
$this->registerJs($script);
?>
