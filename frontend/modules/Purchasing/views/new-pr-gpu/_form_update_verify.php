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
            <div class="form-group ">
                <?= Html::activeLabel($modeledit, 'TMTID_GPU', ['class' => 'col-sm-4 control-label no-padding-right ']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'TMTID_GPU', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white'
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
                        'style' => 'background-color:white',
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
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแบบ</label>
                <div class="col-sm-8">
                    <label><input type="radio" name="แพค" id="แพค" value="yes"/> แพค</label>
                    <label><input type="radio"  name="แพค" id="ชิ้น" value="no"/> ชิ้น</label>
                    <!--                แพค <input type="radio" id="แพค" class="inverted" name="แพค" value="Yes" /> 
                                    ชิ้น <input type="radio" id="ชิ้น" class="inverted" name="ชิ้น" value="No" checked=""/> -->
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($PRPackQty, 2),
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
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($ItemPackSKUQty == null) {
                               echo "0.00";
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
                        'value' => number_format($ItemPackCost, 2),
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
                        'value' => number_format($PROrderQty, 2),
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
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'value' => number_format($PRUnitCost, 2),
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

        </div>

        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit">Save</button>
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
        //document.getElementById("ชิ้น").checked = true;
        //$('input[name=แพค]').addClass("checked");
        //document.getElementById("ชิ้น").checked = true;
        
    });
    //คำนวณขอซื้อ
    $("#vwpritemdetail2-prorderqty").keyup(function () {
        $('input[id="vwpritemdetail2-prorderqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpritemdetail2-prextendedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2-prextendedcost").val('0.00');
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#vwpritemdetail2-prunitcost").keyup(function () {
        $('input[id="vwpritemdetail2-prunitcost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpritemdetail2-prextendedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2-prextendedcost").val('0.00');
        }
    });
    //คำนวณจำนวนแพค
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
    //คำนวณ on chang หน่วยแพค
$('#vwpritemdetail2-itempackid').on('change', function () {
        var TMTID_GPU = $("#vwpritemdetail2-tmtid_gpu").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#vwpritemdetail2-prpackqty").val().replace(/[,]/g, ""));
        var PRUnitCost = parseFloat($("#vwpritemdetail2-prunitcost").val().replace(/[,]/g, ""));
        $.ajax({
            url: "get-qtygpu",
            type: "post",
            data: {TMTID_GPU: TMTID_GPU, ItemPackUnit: ItemPackUnit, qty: qty},
            dataType: 'json',
            success: function (data) {      
                $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                var jj = (SKUQty) * (qty);
                var Total = jj * PRUnitCost;
                if (data.qty == 0) {
                    $('#vwpritemdetail2-prorderqty').val('0.00');
                } else {
                    $("#vwpritemdetail2-prorderqty").val(addCommas(jj.toFixed(2)));
                    $("#vwpritemdetail2-prextendedcost").val(addCommas(Total.toFixed(2)));
                    //var PackID = $(this).find("option:selected").text();
                    //alert( this.value ); // or $(this).val()
                }
            }
        });
    });
    //คำนวณราคาต่อแพค
    $("#vwpritemdetail2-itempackcost").keyup(function () {
        $('input[id="vwpritemdetail2-itempackcost"]').priceFormat({prefix: ''});
        var qty = $("#vwpritemdetail2-prorderqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwpritemdetail2-itempackcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwpritemdetail2-prextendedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwpritemdetail2-prunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2-prunitcost").val('0.00');
        }
    });
    //On Save
    $('#form_update_verify').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
        
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1 )
            {
            $(\$form).trigger("reset");
                    
                    $.pjax.reload({container:'#verify_pjax_id'});
                    $('#verify-modal').modal('hide');
                    $('#form_update_verify').trigger("reset");
                    Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
                    $('#SaveDraftVerify').removeClass('disabled');
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
    var ItemPackID = $("#ItemPackID").val();
       if(ItemPackID == ''||ItemPackID == '0'){
       document.getElementById("ชิ้น").checked = true;
       if ($("input[id=ชิ้น]").is(":checked"))
        {
             $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
             $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").attr('readonly', 'readonly');
             //$("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
             $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").removeAttr('readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
             $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', 'white');
        }
   }else{
        document.getElementById("แพค").checked = true;
        if ($("input[id=แพค]").is(":checked"))
        {
             $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', 'white');
        }
   }
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
             $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
             $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
             $("#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost").attr('readonly', 'readonly');
             //$("#vwpritemdetail2-itempackid").attr('disabled', 'disabled');
             $("#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost").removeAttr('readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
             $('#vwpritemdetail2-prorderqty,#vwpritemdetail2-prunitcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2-prpackqty,#vwpritemdetail2-itempackcost').css('background-color', 'white');
        }
    });
});
JS;
$this->registerJs($script);
?>
